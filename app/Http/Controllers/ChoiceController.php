<?php

namespace App\Http\Controllers;

use App\Allocation;
use App\Choice;
use App\Topic;
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
    public function store(Request $request, Topic $topic)
    {
        if(Auth::user()->role == "Student"){
            $aloCheck = Allocation::where('studentID', Auth::id())->get();
            //If already allocated a topic
            if(!$aloCheck->isEmpty()){
                // Message User with an allocation provided
                return redirect()->back()->with([
                    'status' => 'You already have an Topic Allocated',
                    'type' => 'warning'
                ]);
            } else {
                $countSize = Choice::where('studentID', '=', Auth::id())->count();
                if($countSize >= 3){
                    return redirect()->back()->with([
                        'status' => 'You are making more choices than allowed. Please review your choices.',
                        'type' => 'info'
                    ]);
                } else {
                    $choice = new Choice();
                    $choice->topicID = $topic->id;
                    $choice->studentID = Auth::id();
                    $choice->ranking = $countSize + 1;
                    $choice->pitch = null;
                    $choice->save();
                    // Redirect
                    return redirect()->route('topics.show', $topic)->with([
                        'status' => "Your have chosen $topic->name as a potential topic. This has been sent for review.", 
                        'type' => "success"
                    ]);
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
                // Redirect
                return redirect()->route('topics.index')->with([
                    'status' => "Your choice has been successfully been selected for review.",
                    'type' => 'success'
                ]);
            }
        } else {
            return abort('403', "Forbidden");
        }
    }


    /**
     * 
     */
    public function destroy(Topic $topic){
        if(Auth::user()->role == "Student"){
            // Find associated choice based on Current user and provided 
            $choice = Choice::where('topicID', $topic->id)->where('studentID', Auth::id())->first();
            //Delete choice 
            $choice->delete();
            // Redirect back to user
            return redirect()->route('topic.index')->with([
                'status' => "Your topic choice has been removed.",
                'type' => 'success'
            ]);
        } else {
            return abort('403', "Forbidden");
        }
    }
}
