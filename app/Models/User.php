<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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

    // public function profile(){
    //     return $this->hasOne(Profile::class);
    // }

    // public function article(){
    //     return $this->hasOne(Article::class);
    // }

    // public function articles(){
    //     return $this->hasMany(Article::class);
    // }

    // public function role(){
    //     return $this->belongsTo(Role::class);
    // }

    // public function roles(){
    //     return $this->belongsToMany(Role::class);
    // }


    // public function country(){
    //     return $this->belongsTo(Country::class);
    // }


    // public function comment(){
    //     return $this->hasOne('App\Comment');
    // }

    // public function comments(){
    //     return $this->hasMany('App\Comments');
    // }



    public function verifyUser(){
        return $this->hasOne('App\Models\VerifyUser');
    }

}
