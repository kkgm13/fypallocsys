<?php

namespace App\Http\Controllers;

use App\Proposal;
use App\User;
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
     * Display a listing of the proposals.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('home');
    }

    /**
     * Show the form for creating a new proposal.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role === "Student"){
            $supervisors = User::where('role', '<>', 'Student')->get();
            return view('proposals.create', compact($supervisors));
        } else {
            return abort('403', "Forbidden");
        }
    }

    /**
     * Store a newly created proposal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->role == "Student"){
            $validateData = $request->validate([
                'name' => 'required|string|max:200',
                'description' => 'required|string',
                'supervisorID' => 'required',
                'reasoning' => 'string',
            ]);
            $validateData['studentID'] = Auth::id();
            // Create proposal
            $proposal = Proposal::create($validateData);

            // Notify Supervisor about proposal

            // Redirect
            return redirect()->route('proposals.index')->with('success', "Your $proposal->name proposal has been successfully sent off to the proposed supervisor");
        } else {
            return abort('403', "Forbidden");
        }
    }

    /**
     * Display the specified proposal.
     *
     * @param  \App\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function show(Proposal $proposal)
    {
        return view('proposals.show', ['proposal' => $proposal]);
    }

    /**
     * Show the form for editing the specified proposal.
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
     * Update the specified proposal in storage.
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
     * Remove the specified proposal from storage.
     *
     * @param  \App\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proposal $proposal)
    {
        // if(Auth::user()->role != "Student"){
            
        // } else {
            return abort('403', "Forbidden");
        // }
    }

    /**
     * Supervisor's Decision of the specified Proposal.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function decision(Request $request, Proposal $proposal){
        if(Auth::user()->role == "Student" || Auth::id() == $proposal->supervisorID){
            if($request->decision === "accepted"){

            } else {

            }
            return redirect()->route('proposals.index')->with('success', "The proposal has been successfully sent off to the proposed supervisor");;
        } else {
            return abort(403, "Forbidden");
        }
    }

    // Private accepted
    // Private rejected
}
