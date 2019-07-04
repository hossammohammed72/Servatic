<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
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
