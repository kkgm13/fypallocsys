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

    //--------------------------------//
}