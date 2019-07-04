<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function client(){
    return $this->belongsTo('App\Models\Client');
}
    public function agent(){
        return $this->belongsTo('App\Models\Agent');
    }
    public function company(){
        return $this->belongsTo('App\Models\Company');
    }
}
