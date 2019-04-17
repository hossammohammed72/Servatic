<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ChatKit;
use App\Models\Agent;
use App\Models\Client;
class ChatController extends Controller
{
    //
    public function __construct(){
        $this->chatkit = new ChatKit(env('PUSHER_INSTANCE_LOCATOR'),env('PUSHER_KEY'));
    }
    public function ِaddClientToRoom($user = array()){

    }
    public function testAgentUser(){
        $agents = Agent::all();
        $users = array();
        foreach($agents as $agent){
            $users['users'][]=array(
                'name'=>$agent->name,
                'id'=>$agent->email,
            );
        }
        $this->chatkit->createUsers($users);
    }
}
