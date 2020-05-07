<?php

namespace App\Http\Controllers;

use App\Allocation;
use App\Choice;
use App\Mail\AllocatedLetter;
use App\Topic;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TopicController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role === "Student"){
            $topics = Topic::all();

            return view('topics.index',['topics' => $topics]);
        } else {
            return abort(403, "Forbidden");
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role != "Student"){
            $supervisors = User::where('role', '<>', 'Student')->get();
            return view('topics.create', ['supervisors' => $supervisors]);
        } else {
            return abort(403, " NOT ALLOWED");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        if(Auth::user()->role != "Student"){

            // Validate the Data
            $validateData = $this->validate($request, Topic::validationRules(), Topic::validationMessages());        

            // Get Current auth user
            if(Auth::user()->role == "Supervisor"){
                $validateData['supervisorID'] = Auth::id(); // Get Current Auth
            } else {
                $validateData['supervisorID'] = $request->supervisorID; // Get Supervisor Selected auth
            }

            // Create the Topic
            $topic = Topic::create($validateData);

            // Create the Topic Documents and associate with the topic
            if($request->hasFile('topicDocuments')){
                (new TopicDocumentController)->store($request);
            }
            // Redirection
            return redirect()->route('topics.show', $topic)->with([
                'status', "The topic has been successfully added",
                'type' => 'success',
            ]);
        } else {
            return abort('403', "You are unauthorized");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {
        $studentChoices = Choice::where('topicID', $topic->id)->pluck('studentID')->toArray();
        return view('topics.show', ['topic' => $topic, 'choices' => $studentChoices]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(Topic $topic)
    {
        if(Auth::id() == $topic->supervisorID || Auth::user()->role === "Module Leader" ){
            $supervisors = User::where('role', '<>', 'Student')->get();
            return view('topics.edit', ['topic'=> $topic, 'supervisors'=>$supervisors]);
        } else {
            return abort(403, "Forbidden");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topic $topic)
    {
        if(Auth::id() == $topic->supervisorID || Auth::user()->role === "Module Leader"){
            // Validate the Data
            $validateData = $request->validate([
                'name' => 'required|string|max:200',
                'description' => 'required|string',
            ]);
            // Get Current auth user
            if(Auth::user()->role == "Module Leader"){
                $validateData['supervisorID'] = $request->supervisorID; // Get Supervisor Selected auth
            }
            // Create the Topic
            $topic->update($validateData);

            return redirect()->route('topics.show', $topic)->with([
                'status', "The topic has been successfully updated",
                'type' => 'success',
            ]);
        } else {
            return abort(403, "Forbidden");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        if(Auth::id() === $topic->supervisorID || Auth::user()->role === "Module Leader"){
            $topic->delete();
            return redirect()->route('topics.index')->with([
                'success' => "The topic has been successfully deleted", 
                'type' => "success"
            ]);
        } else {
            return abort(403, "Forbidden");
        }
    }

    /**
     * Allocate the Student to the topic
     */
    public function allocate(Request $request, Topic $topic){
        if(Auth::user()->role != "Student"){
            $user = json_decode($request->user);
            $aloCheck = Allocation::where('studentID', $user->id)->get();
            //If already allocated
            if(!$aloCheck->isEmpty()){
                // Message User with an allocation provided
                return redirect()->back()->with([
                    'status' => 'Student has been already allocated',
                    'type' => 'warning'
                ]);
            } else {
                // Create Allocation
                $allocation = new Allocation();
                $allocation->studentID = $user->id;
                $allocation->topicID = $topic->id;
                $allocation->supervisorID = $topic->supervisor->id;
                $allocation->superAuth = 1;
                $allocation->save();

                // Update the Topic
                $topic->update(['studentID'=> $user->id]);

                // Notify Student
                Mail::to($allocation->student->email)->send(new AllocatedLetter($allocation));
                // Redirect
                return redirect()->route('home')->with([
                    'status' => "You have chosen student for this topic. The system is informing the student.",
                    'type' => 'success',
                ]);
            }
        } else {
            return abort(404, "Not Found");
        }
    }

    // private function 
}
