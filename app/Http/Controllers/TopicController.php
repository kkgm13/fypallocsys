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
        
        
        // Get Current auth user
        if(Auth::user() == "Supervisor"){
            dd("hit1");
            $request->supervisorID = Auth::id(); 
        } else if(Auth::user() === "Module Leader"){
            dd("hit");
            // $request->supervisorID);
        } else {
            dd("here");
        }
        dd("skips All");
        // dd($request);

        $validateData = $request->validate([
            'name' => 'required|string|max:200',
            'description' => 'required|string',
            'isMCApprove' => 'required|boolean',
            'isCBApprove' => 'required|boolean',
            'supervisorID' => 'required',
        ]);

        Topic::create($validateData);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        //
    }
}
