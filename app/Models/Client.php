<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\PusherUser;


class Client extends model
{
    public function ticket(){
        $this->hasMany('App\Models\Ticket');
    }

    public function company(){

        $this->belongsTo('App\Models\Company');
    }
    public function room(){
        return $this->hasMany('App\Models\Room');
    }
}
