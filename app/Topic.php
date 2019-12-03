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

    /**
     * Supervisor Relationship
     */
    public function supervisor(){
        return $this->belongsTo('App\User', 'supervisorID');
    }

    /**
     * Interested Students Relationship
     */
    public function students(){
        return $this->hasMany('App\User', 'studentID');
    }

    /**
     * Chosen Student Relationship
     */
    public function chosenStudent(){
        return $this->belongsTo('App\User', 'studentID');
    }

    /**
     * Get all relevant documents of this topic
     */
    public function documents(){
        return $this->hasMany('App\TopicDocument', 'topicID');
    }
}
