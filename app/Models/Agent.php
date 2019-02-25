<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\eloquent\softDeletes;

class Agent extends Model
{
    protected $fillable = ['user_id', 'company_id'];
    use softDeletes;
    public function user(){
        $this->belongsTo('App\User');
    }
    public function company(){
        $this->belongsTo('App\Models\Company');
    }
    public function ticket(){
        $this->hasMany('App\Models\Ticket');
    }
}
