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
        'name', 'description', 'userID', 'supervisorID', 'isMCApprove', 'isCBApprove', 'prequisites', 'isMCApprove', 'isCBApprove'
    ];
}
