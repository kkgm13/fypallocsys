<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'studentID', 'supervisorID', 'reasoning'
    ];

    //--------------------------------//

    /**
     * Proposed supervisor of student's proposal
     */
    public function supervisor(){
        return $this->belongsTo('App\User', 'supervisorID', );
    }

    /**
     * Main proposal person
     */
    public function student(){
        return $this->belongsTo('App\User', 'studentID');
    }

    //--------------------------------//


    /**
     * Form Validation Rules for Topic Forms
     */
    public static function validationRules(){
        return [
            'name' => 'required|string|max:200',
            'description' => 'required|string',
            'supervisorID' => 'required|not_in:0',
            'reasoning' => 'required|string',
        ];
    }

    /**
     * Form Error Messages for Topic Forms
     */
    public static function validationMessages(){
        return [
            'name.required' => 'A Proposal Name is required.',
            'description.required' => 'A Proposal Description must be provided',
            'supervisorID.required' => 'Please select a Proposal Supervisor',
            'reasoning.required' => 'You must provide a reason to do this proposal and why this supervisor'
        ];
    }

    public function accept(){

    }

    public function decline(){

    }

}
