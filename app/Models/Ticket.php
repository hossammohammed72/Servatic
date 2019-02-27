<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\database\Eloquent\softDeletes;

class Ticket extends Model
{
    use softDeletes;
    public function client(){
        $this->belongsTo('App\Models\Client');
    }
    public function agent(){
        $this->belongsTo('App\Models\Agent');
    }
    public function company(){
        $this->belongsTo('App\Models\Company');
    }
}
