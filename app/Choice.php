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
    public function interestedStudents(){
        return $this->hasMany('App\User', 'id','studentID');
    }

    /**
     * Get associated Topic
     */
    public function topic(){
        return $this->belongsTo('App\Topic', 'topicID');
    }



    //--------------------------------//

    /**
     * Form Validation Rules for Topic Forms
     */
    public static function validationRules(){
        return [
            'ranking' => 'required|integer|between:1,3',
            'pitch' => 'required|string|max:600',
        ];
    }

    /**
     * Form Error Messages for Topic Forms
     */
    public static function validationMessages(){
        return [
            'ranking.required' => 'Please rank this topic based on your preferences.',
            'ranking.empty' => 'Please rank this topic based on your preferences.',
            'ranking.between' => 'Please rank this topic between :min to :max.',
            'pitch.required' => 'Please provide context to why you want this topic.',
            'pitch.empty' => 'Please provide context to why you want this topic.',
            'pitch.max' => 'You are over the character limit. Please concise.'
        ];
    }
    
}
