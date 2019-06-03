<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Company;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function agent(){
        return $this->hasOne('App\Models\Agent');
    }
    public function moderator(){
        return $this->hasOne('App\Models\Moderator');
    }
    public function admin(){
        return $this->hasOne('App\Models\Admin');
    }
    /*
    * @return user model data
    */ 
    public function type(){
        if(!is_null($this->admin)){
            $this->admin->attributes['type']='admin';
            return $this->admin->attributes;
        }
        if(!is_null($this->moderator)){
            $companyName = Company::where('id',$this->moderator->company_id)->first()->only('name');
            $this->moderator->attributes['type']='moderator';
            $this->moderator->attributes['company_name']= $companyName['name'];
            return $this->moderator->attributes;
        }
        if(!is_null($this->agent)){
            $companyName = Company::where('id',$this->agent->company_id)->first()->only('name');
            $this->agent->attributes['type']='agent';
            $this->agent->attributes['company_name']= $companyName['name'];
            return $this->agent->attributes;
        }
        return null;
    }
    public function getJWTIdentifier()
    {
      return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
      return [];
    }
}
