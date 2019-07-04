<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Moderator extends Model
{

    public function company(){

        $this->belongsTo('App\Models\Company');
    }

    public function user(){

        $this->belongsTo('App\User','user_id','id');
    }
}
