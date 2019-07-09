<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Chatkit\Chatkit;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Company;
use App\Models\Ticket;
use App\Models\Room;

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

        $client = $this->getClient($request);
        $freeAgent= Agent::with('user')->where('busy',false)->where('company_id',$request->company_id)->first();
        if(!is_null($freeAgent)){
            $this->chatkit->createRoom([
                'creator_id'=>$freeAgent->user->email,
                'name'=>'Servatic',
                'user_ids'=>[$client->email],
            ]);
            $room = new Room();
            $roomData =  $this->chatkit->createRoom([
                'creator_id'=>$freeAgent->user->email,
                'name'=>'Servatic',
                'user_ids'=>[$client->email],
            ]);
            $room->id =(int)$roomData['body']['id'];
            $room->client_id = $client->id;
            $room->agent_id = $freeAgent->user_id;
            $room->save(); 
            $this->makeTicket($client,$freeAgent);
            Agent::where('user_id',$freeAgent->user_id)->update(['busy'=>true]);

        }else {
            // put client in queue
            return response()->json(['msg'=>'no free agents available'],503);   
        }
        return response()->json(['msg'=>'success'],200);

    }
    private function getClient(Request $request){
        if(Client::where('email',$request->email)->count() != 1)
        {
            $client = new Client();
            $client->email = $request->email;
            $client->name = $request->name;
            $client->company_id = $request->company_id;
            $client->save();
            $this->chatkit->createUser(['id'=>$request->email,'name'=>$request->name]);
            return $client;
        }else {
            return Client::where('email',$request->email)->first();
        }

    }
    private function makeTicket(Client $client,Agent $agent){
        $ticket = new Ticket();
        $ticket->company_id = $client->company_id;
        $ticket->agent_id = $agent->user_id;
        $ticket->client_id = $client->id;
        return $ticket->save();
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
}
