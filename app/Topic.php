<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Topic Model
 * 
 * This is the Model that provides context with a 
 */
class Topic extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'userID', 'supervisorID', 'isMCApprove', 'isCBApprove',
    ];
}
