<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'topicID', 'studentID', 'ranking', 'pitch',
    ];
    
    //--------------------------------//

    /**
     * Choice Selected by Student
     */
    public function student(){
        return $this->hasMany('App\User', 'studentID');
    }

    /**
     * Get associated Topic
     */
    public function topic(){
        return $this->belongsTo('App\Topic', 'topicID');
    }

    //--------------------------------//

    
}
