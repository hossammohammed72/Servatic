<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Chatkit\Chatkit;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Company;
use App\Models\Ticket;
use App\Models\Room;
use App\Models\Queue;
use App\User;
use Chatkit\ChatkitException;
use DB;
use Validator;
Use Carbon\Carbon;
use DateTime;
use DateTimeZone;


class ChatController extends Controller
{
    //
    public function __construct(){
        $this->chatkit = new ChatKit(
            ['instance_locator'=>env('PUSHER_INSTANCE_LOCATOR'),
            'key'=>env('PUSHER_KEY')
            ]);
    }
    public function ِaddClientToRoom(Request $request){
        $validator = validator::make($request->all(), [
            'name' => 'required|max:255|string',
            'email' => 'required|email',
            'company_id' =>'required|exists:companies,id',
            'waiting_time' =>'required|string',
        ]);
        if($validator->fails())
            return response()->json([$validator->errors()], 401);


        $client = $this->getClient($request);
        $freeAgent= Agent::with('user')->where('busy',false)
            ->where('company_id',$request->company_id)->first();

        if(!is_null($freeAgent)){
            $room = new Room();
            $roomData =  $this->chatkit->createRoom([
                'creator_id'=>$freeAgent->user->email,
                'name'=>'Servatic',
                'user_ids'=>[$client->email],
            ]);            
            $room->id =$roomData['body']['id'];
            $room->client_id = $client->id;
            $room->agent_id = $freeAgent->user_id;
            $room->save();
            $waiting_time = $request->waiting_time;
            $this->makeTicket($client,$freeAgent,$waiting_time);
            Agent::where('user_id',$freeAgent->user_id)->update(['busy'=>true]);

            company::where('id',$request->company_id)->where('client_in_queue','>',0)
                ->decrement('client_in_queue',1);
            return response()->json(['msg'=>'success','roomId'=>$roomData['body']['id']],200);

        }
        else {
            company::where('id',$request->company_id)->increment('client_in_queue',1);
            return response()->json(['msg'=>'no free agents available'],503);   
        }

    }
    //creat client if he new registered
    private function getClient(Request $request){
        if(Client::where('email',$request->email)->count() != 1)
        {
            $client = new Client();
            $client->email = $request->email;
            $client->name = $request->name;
            $client->company_id = $request->company_id;
            $client->save();
            try{
            $this->chatkit->createUser(['id'=>$request->email,'name'=>$request->name]);
            } catch (ChatkitException $e){
                
            }
            return $client;
        }else{
            return Client::where('email',$request->email)->first();
        }

    }
    private function makeTicket(Client $client,Agent $agent,$waiting_time){
        $ticket = new Ticket();
        $ticket->company_id = $client->company_id;
        $ticket->agent_id = $agent->user_id;
        $ticket->client_id = $client->id;

        $ticket->waiting_time = waitingTime($waiting_time);
        return $ticket->save();
    }

    public function waitingTime($login_time){
        $now = new DateTime('now', new DateTimeZone('Africa/Cairo'));
        $start_chatting= new DateTime($login_time,new DateTimeZone('Africa/Cairo'));
        $difference_time = $now->diff($start_chatting);
        $waiting_time = $difference_time->format('%h').":".$difference_time->format('%i').":".$difference_time->format('%s');
        return $waiting_time;
    }

    /**
     *  pusher auth
     */
    public function pusherAuth(Request $request){
        return $chatkit->authenticate([ 'user_id' => $request->id ]);
    }
    public function testAgentUser(){
        $agents = Agent::with('user')->last();
        $users = array();
        foreach($agents as $agent){
            $users['users'][]=array(
                'name'=>$agent->user->name,
                'id'=>$agent->user->email,
            );
        }
        $this->chatkit->createUsers($users);
        return response()->json(['success'=>true],200);
    }

    public function ِgetRoomClient(Room $room){
        $ticket = Ticket::where('agent_id',$room->agent_id)
        ->where('client_id',$room->client_id)
        ->where('complaint',null)
        ->where('action',null)->first();
        $client = Client::find($room->client_id);
        return response()->json(['client'=>$client,'ticket'=>$ticket]);

    }
    //Add client to queue 
    public function addToQueue(Request $request){
        $validator = validator::make($request->all(), [
            'name' => 'required|max:255|string',
            'email' => 'required|email',
            'company_id' =>'required|exists:companies,id',
        ]);
        if($validator->fails())
            return response()->json([$validator->errors()], 401);

        $client = $this->getClient($request);
       
        if(Queue::where('client_id',$client->id)->count()!=1 && Queue::where('company_id',$client->company_id)->count()!=1){
            $queue = new Queue();   
            $queue->client_id = $client->id;
            $queue->company_id = $client->company_id;
            $queue->save();
            
            return response()->json($client,200);
        }else{
            return response()->json(['msg'=>'Already in queue'],406); 
        }
        
    }

   //number clients which every client waits
    public function numberClients(request $request){
        //$num_client_queue = Queue::where('company_id',$request->company_id)-     
        if(Queue::where('company_id', $request->company_id)->where('client_id', $request->client_id)->count()){
            $company_client = Queue::where('client_id','<',$request->client_id)->count();   
            return response()->json($company_client, 200);
        }else{
            return response()->json(['msg'=>'client not found'],404);
        }
    }

    public function fetchClientFromQueue(request $request){
        $client = Queue::where('company_id',$request->company_id)->first(); 
        return Client::where('id',$client->client_id);
        $agent = Agent::where('user_id', $request->agent_id)->get();
        
        $room = new Room();
        $roomData =  $this->chatkit->createRoom([
            'creator_id'=>$agent->user->email,
            'name'=>'Servatic',
            'user_ids'=>[$client->email],
        ]);            
        $room->id =$roomData['body']['id'];
        $room->client_id = $client->id;
        $room->agent_id = $agent->user_id;
        $room->save();

        $start_chat_time = $request->start_chat_time;
        $this->makeTicket($client,$agent,$start_chat_time);
        Agent::where('user_id',$agent->user_id)->update(['busy'=>true]);
        Room::where('id',$room->id)->delete();
        $client->delete();
       // return response()->json(['msg'=>'success'],200);      
    }
    

}
