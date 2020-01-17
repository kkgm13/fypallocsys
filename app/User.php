<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName','lastName', 'email', 'password', 'username', 'sun','role', 'bio'
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

    //--------------------------------//

    /**
     * Topic Associated to a user
     */
    public function topics(){
        return $this->hasMany('App\Topic', 'id');
    }

    /**
     * Topic assigned to Supervisor User
     */
    public function proposals(){
        return $this->hasMany('App\Proposal', 'supervisorID', 'id');
    }

    /**
     * Topic assigned to Student
     */
    public function proposalSent(){
        return $this->hasMany('App\Proposal', 'studentID', 'id');
    }

    /**
     * Choices associated to user
     */
    public function choices(){
        return $this->hasMany('App\Choice', 'studentID', 'id');
    }

    //--------------------------------//
}
