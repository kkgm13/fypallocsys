<?php

namespace App\Http\Controllers;

use App\Topic;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supervisors = User::where('role', '<>', 'Student')->get();
        return view('topics.create', compact($supervisors));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the Data
        $validateData = $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'required|string',
            'prequisites' => 'sometimes|required|string',
            'isMCApprove' => 'sometimes|required|boolean',
            'isCBApprove' => 'sometimes|required|boolean',
            'supervisorID' => 'sometimes|required',
        ]);
        
        // Get Current auth user
        if($request->supervisorID->role == "Supervisor"){
            $validateData['supervisorID'] = Auth::id(); // Get Current Auth
        } else if($request->supervisorID->role == "Module Leader"){
            $validateData['supervisorID'] = $request->supervisorID->id; // Get Supervisor Selected auth
        }

        // Create the Topic
        $topic = Topic::create($validateData);
        
        // Redirect
        // return redirect()->route('topics.show', compact($topic))->with('success', "The topic has been successfully added");
        return redirect()->route('topics.index')->with('success', "The topic has been successfully added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function show(Topic $topic)
    {
        return view('topics.show', compact($topic));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function edit(Topic $topic)
    {
        $supervisors = User::where('role', '<>', 'Student')->get();
        return view('topic.edit', compact($topic));
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
        // Validate the Data
        $validateData = $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'required|string',
            'isMCApprove' => 'required|boolean',
            'isCBApprove' => 'required|boolean',
        ]);
        
        // Get Current auth user
        if($request->supervisorID->role == "Module Leader"){
            $validateData['supervisorID'] = $request->supervisorID->id; // Get Supervisor Selected auth
        }

        // Create the Topic
        $topic->update($validateData);
        // return redirect()->route('topics.show', compact($topic))->with('success', "The topic has been successfully updated");
        return redirect()->route('topics.index')->with('success', "The topic has been successfully updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        $topic->delete();
        return redirect()->route('topics.index')->with('success', "The topic has been successfully deleted");
    }
}
