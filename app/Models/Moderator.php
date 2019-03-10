<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Moderator extends Model
{
    use SoftDeletes;

    public function company(){

        $this->belongsTo('App\Models\Company');
    }

    public function user(){

        $this->belongsTo('App\User','user_id','id');
    }
}
