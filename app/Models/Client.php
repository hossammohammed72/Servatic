<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function ticket(){
        $this->hasMany('App\Models\Ticket');
    }

    public function company(){

        $this->belongsTo('App\Models\Company');
    }

}
