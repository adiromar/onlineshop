<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'suspend', 'verifyToken',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function products(){
        return $this->hasMany('App\Product');
    }

    public function profile(){
        return $this->hasOne('App\Profile');
    }

    public function supplier(){
        return $this->hasOne('App\Supplier');
    }

    public function roles(){
        return $this->belongsToMany('App\Role');
    }

    public function photos(){
        return $this->hasMany('App\Photos');
    }

    public function reviews(){
        return $this->hasMany('App\Reviews', 'userId');
    }

    public function orders(){
        return $this->hasMany('App\Orders');
    }

    public function wishlists(){
        return $this->hasMany('App\Wishlist', 'userId');
    }

    public function hasRoles($roles) {
        
        if ( is_array($roles) ) {
            if ( $this->roles()->whereIn('role', $roles)->count() > 0 ) return true;
        }else{
            if ( $this->roles()->where('role', $roles)->first() ) return true;
        }
        return false;
    }

}
