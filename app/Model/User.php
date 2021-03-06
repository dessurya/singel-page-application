<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Hash;

class User extends Authenticatable{
    
    use Notifiable;
	protected $table = 'prof_user';
    protected $fillable = [
        'name', 'email', 'password', 'flag_status'
    ];
    protected $hidden = [
        'password'
    ];

    public function getUserDetils(){
        return $this->hasOne('App\Model\UserDetils', 'user_id', 'id');
    }

    public function setPasswordAttribute($password){ 
        if ($password == null) {
            return null;
        }else{
            return $this->attributes['password'] = Hash::make($password); 
        }
    }
}
