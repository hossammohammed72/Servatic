<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    public function company(){
        $this->belongsToMany('App\Models\Company');
    }
    public function ticket(){
        $this->hasMany('App\Models\Ticket');
    }
}
