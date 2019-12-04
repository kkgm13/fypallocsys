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

    //--------------------------------//
    /**
     * Document related to topic
     */
    public function topic(){
        return $this->belongsTo('App\Topic', 'topicID');
    }

    //--------------------------------//

    /**
     * List of approved files for Images
     */
    public static function approvedImageTypes(){
        return ['jpeg','jpg','png','bmp',];
    }
}
