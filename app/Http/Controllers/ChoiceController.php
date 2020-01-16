<?php

namespace App\Http\Controllers;

use App\Allocation;
use App\Choice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == "Student"){
            $choices = Choice::where('studentID', Auth::id())->orderBy('ranking')->get();
            return view('choices.index', ['choices' => $choices]);
        } else {
            return abort(403, "NOT ALLOWED");
        }
    }

    /**
     * Store a newly selected choice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->role == "Student"){
            //If already allocated a topic
            if(is_null(Allocation::where('studentID', Auth::id())->get())){
                // Alert to user that they are allocated a topic already
            } else {
                // Advise if a forth choice is made
                if(Choice::where('studentID', '=', Auth::id())->count() > 3){
                    // Return and show warning of more than 3
                } else {
                    $validateData = $this->validate($request, Choice::validationRules(), Choice::validationMessages()); 
                    $validateData['studentID'] = Auth::id();
                    // Notify Supervisor about proposal
                    $choice = Choice::create($validateData);
                    // Redirect
                    return redirect()->route('topics.index')->with('status', "Your choice has been successfully been selected for review.");
                }
            }
        } else {
            return abort('403', "Forbidden");
        }
    }

    public function update(Request $request, Choice $choice){
        if(Auth::user()->role == "Student"){
            // Advise if a forth choice is made
            if(Choice::where('studentID', '=', Auth::id())->count() > 3){
                // Return and show warning of more than 3
            } else {
                $validateData = $this->validate($request, Choice::validationRules(), Choice::validationMessages()); 
                $validateData['studentID'] = Auth::id();
                // Notify Supervisor about proposal
                $choice = Choice::create($validateData);
                // Redirect
                return redirect()->route('topics.index')->with('status', "Your choice has been successfully been selected for review.");
            }
        } else {
            return abort('403', "Forbidden");
        }
    }


    public function delete(Choice $choice){
        if(Auth::user()->role == "Student"){
            // If student selects this topic
            //Delete choice 
        } else {
            return abort('403', "Forbidden");
        }
    }
}
