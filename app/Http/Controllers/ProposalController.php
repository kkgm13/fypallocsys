<?php

namespace App\Http\Controllers;

use App\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
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
        return redirect()->route('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role === "Student"){
            $supervisors = Users::where('role', '<>', 'Student')->get();
            return view('proposals.create', compact($supervisors));
        } else {
            return abort('403', "Forbidden");
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
        // dd(Auth::user()->role);
        if(Auth::user()->role == "Student"){
            $validateData = $request->validate([
                'name' => 'required|string|max:200',
                'description' => 'required|string',
                'supervisorID' => 'required',
            ]);
            $validateData['studentID'] = Auth::id();
            // Create proposal
            $proposal = Proposal::create($validateData);

            // Redirect
            // return redirect()->route('topics.show', compact($topic))->with('success', "The topic has been successfully added");
            return redirect()->route('proposals.index')->with('success', "The proposal has been successfully sent off to the proposed supervisor");
        } else {
            return abort('403', "Forbidden");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function show(Proposal $proposal)
    {
        return view('proposals.show', compact($proposal));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function edit(Proposal $proposal)
    {
        // if(Auth::user()->role != "Student"){
            
        // } else {
            return abort('403', "Forbidden");
        // }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proposal $proposal)
    {
        // if(Auth::user()->role != "Student"){
            
        // } else {
            return abort('403', "Forbidden");
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proposal $proposal)
    {
        // if(Auth::user()->role != "Student"){
            
        // } else {
            // return abort('403', "Forbidden");
        // }
    }
}
