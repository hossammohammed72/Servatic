<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{

    use SoftDeletes;
    public function clients(){

        $this->hasMany('App\Models\Client');
    }

    public function moderators(){

        $this->hasMany('App\Models\Moderator');
    }
    public function agents(){

        $this->hasMany('App\Models\Agent');
    }
}
