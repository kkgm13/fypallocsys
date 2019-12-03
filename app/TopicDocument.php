<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopicDocument extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'topicID', 'fileName'
    ];
}
