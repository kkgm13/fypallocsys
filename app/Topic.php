<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Topic Model
 * 
 * This is a Model containing the characteristics of a Topic, provided by the Supervisors
 */
class Topic extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'studentID', 'supervisorID', 'isMCApprove', 'isCBApprove', 'prequisites', 'isMCApprove', 'isCBApprove'
    ];

    public function supervisor(){
        return $this->belongsTo('App\User', 'supervisorID');
    }

    public function students(){
        return $this->hasMany('App\User', 'studentID');
    }

    public function chosenStudent(){
        return $this->belongsTo('App\User', 'studentID');
    }
}
