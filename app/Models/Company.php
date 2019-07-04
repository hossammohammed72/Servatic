<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    public function clients(){

        $this->hasMany('App\Models\Client');
    }

    public function moderators(){

        $this->hasMany('App\Models\Moderator');
    }
    public function agents(){

        $this->hasMany('App\Models\Agent');
    }
    public function tickets(){

        $this->hasMany('App\Models\Ticket');
    }
}
