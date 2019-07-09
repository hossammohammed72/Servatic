<?php


namespace App;

use Chatkit\Chatkit;
use Illuminate\Database\Eloquent\Model;
use Chatkit\Exceptions\ChatkitException;



class PusherUser extends Model{

    public function save(array $options = [])
    {
       $model= parent::save($options);
        try {
        $this->chatkit = new ChatKit(
            ['instance_locator'=>env('PUSHER_INSTANCE_LOCATOR'),
                'key'=>env('PUSHER_KEY')
            ]);
        $this->chatkit->createUser([
            'id' =>$this->user->email,
            'name' => $this->user->name
        ]);
        return $model;
        }
        catch (ChatkitException $e){
            return $model;
        }
    }


}