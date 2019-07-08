<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\PusherUser;


class Agent extends PusherUser
{
    protected $fillable = ['user_id', 'company_id'];

    public  function user(){
        return $this->belongsTo('App\User');
    }
    public function company(){
        return $this->belongsTo('App\Models\Company');
    }
    public function ticket(){
        return $this->hasMany('App\Models\Ticket');
    }

    public function room(){
        return $this->hasMany('App\Models\Room');
    }
}
