<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
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
