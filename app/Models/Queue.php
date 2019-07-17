<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    public function clients(){

        $this->hasMany('App\Models\Client');
    }

    public function company(){

        $this->hasMany('App\Models\Company');
    }
}
