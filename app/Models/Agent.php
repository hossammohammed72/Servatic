<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\eloquent\softDeletes;

class Agent extends Model
{
    use softDeletes;
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
}
