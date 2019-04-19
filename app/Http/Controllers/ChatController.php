<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Chatkit\Chatkit;
use App\Models\Agent;
use App\Models\Client;
use App\Models\Company;
class ChatController extends Controller
{
    //
    public function __construct(){
        $this->chatkit = new ChatKit(['instance_locator'=>env('PUSHER_INSTANCE_LOCATOR'),'key'=>env('PUSHER_KEY')]);
    }
    public function ِaddClientToRoom(Request $request){

        $agent= Agent::with('user')->first();
       if(Client::where('email',$request->email)->count() == 0)
        {
            $client = new Client();
            $client->email = $request->email;
            $client->name = $request->name;
            $client->company_id = Company::InRandomOrder()->first()->id;
            $client->save();
            $this->chatkit->createUser(['id'=>$request->email,'name'=>$request->name]);
        }
        $this->chatkit->createRoom([
            'creator_id'=>$agent->user->email,
            'name'=>'Servatic',
            'user_ids'=>[$request->email],
        ]);
        return response()->json(['msg'=>'success'],200);

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
}
