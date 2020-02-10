<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'studentID','supervisorID','proposalID','topicID','superAuth','modAuth',
    ];

    //--------------------------------//

    /**
     * Get the associated Allocated Topic
     */
    public function topic(){
        return $this->belongsTo('App\Topic', 'topicID');
    }
    

     /**
      * Get the associated Allocated Proposal
      */
    public function proposal(){
        return $this->belongsTo('App\Proposal', 'proposalID');
    }

    //--------------------------------//
}