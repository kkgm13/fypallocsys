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

    //--------------------------------//

    /**
     * Supervisor Relationship
     */
    public function supervisor(){
        return $this->belongsTo('App\User', 'supervisorID');
    }

    /**
     * Interested Students Relationship
     */
    public function interested(){
        return $this->belongsToMany('App\User', 'choices', 'topicID', 'studentID');
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

    //--------------------------------//

    /**
     * Form Validation Rules for Topic Forms
     */
    public static function validationRules(){
        return [
            'name' => 'required|string|unique:topics,name|max:200',
            'description' => 'required|string',
            'prequisites' => 'sometimes|nullable|string',
            'corequisites' => 'sometimes|nullable|string',
            'isMCApprove' => 'sometimes',
            'isCBApprove' => 'sometimes',
            'supervisorID' => 'sometimes|required',
            'topicDocuments' => 'sometimes|nullable|max:1048576'
        ];
        //mimes:jpeg,jpg,png,bmp,doc,docx,pdf
    }

    /**
     * Form Error Messages for Topic Forms
     */
    public static function validationMessages(){
        return [
            'name.required' => 'A Topic Name is required.',
            'description.required' => 'A Topic Description is required.',
            'name.unique' => 'This topic name is already being used by a different supervisor.',
            'topicDocuments.mimes' => 'Supported files only are JPEG, PNG & BMP images, Word and PDF documents only ',
            'topicDocuments.max' => 'The Document is large to save. Make sure it\'s within 128MB',
        ];
    }
}
