<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Chatkit\Chatkit;
use App\Models\Agent;
use App\Models\Client;
class ChatController extends Controller
{
    //
    public function __construct(){
        $this->chatkit = new ChatKit(['instance_locator'=>env('PUSHER_INSTANCE_LOCATOR'),'key'=>env('PUSHER_KEY')]);
    }
    public function ِaddClientToRoom($user){

        $agent= Agent::with('user')->first();
        $this->chatkit->createUser([
            'id'=>$user,
            'name'=>'Hossam'
        ]);
        $this->chatkit->createRoom([
            'creator_id'=>$agent->user->email,
            'name'=>'Servatic',
            'user_ids'=>[$user],
        ]);

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
