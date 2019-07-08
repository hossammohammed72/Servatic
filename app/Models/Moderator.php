<?php

namespace App\Models;

use App\PusherUser;
use Illuminate\Database\Eloquent\Model;
class Moderator extends PusherUser
{

    public function company(){

        $this->belongsTo('App\Models\Company');
    }

    public function user(){

        $this->belongsTo('App\User','user_id','id');
    }
}
