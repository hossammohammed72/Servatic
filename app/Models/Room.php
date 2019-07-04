<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\database\Eloquent\softDeletes;

class Room extends Model
{
    use softDeletes;
    public function client(){
        return $this->hasMany('App\Models\Client');
    }
    public function agents(){

        $this->hasMany('App\Models\Agent');
    }

}
