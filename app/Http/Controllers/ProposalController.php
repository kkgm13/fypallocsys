<?php

namespace App\Http\Controllers;

use App\Mail\ProposalAccept;
use App\Mail\ProposalSent;
use App\User;
use App\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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
        $proposals = null;
        if(Auth::user()->role === "Student"){
            $proposals = Proposal::where('studentID', Auth::id())->get();
        } else {
            $proposals = Proposal::where('supervisorID', Auth::id())->get();
        }
        return view('proposals.index', ['proposals' => $proposals]);
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
            return view('proposals.create', ['supervisors' => $supervisors]);
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

            $validateData = $this->validate($request, Proposal::validationRules(), Proposal::validationMessages()); 
            
            $validateData['studentID'] = Auth::id();
            // Create proposal
            $proposal = Proposal::create($validateData);
            
            // Notify Supervisor about proposal
            Mail::to($proposal->supervisor->email)->send(new ProposalSent($proposal));

            // Redirect
            return redirect()->route('proposals.index')->with('status', "Your $proposal->name proposal has been successfully sent off to the proposed supervisor");
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
                $this->accepted($request, $proposal);
            } else {
                
            }
            return redirect()->route('proposals.index')->with('success', "The proposal has been successfully sent off to the proposed supervisor");;
        } else {
            return abort(403, "Forbidden");
        }
    }

    /**
     * Proposal has been accepted
     * 
     * @param Request   $request
     * @param Proposal  $proposal
     */
    private function accepted(Request $request, Proposal $proposal){

        //Create Allocation
        $allocation = null;
        $allocation->proposalID = $proposal->id;
        $allocation->superAuth = 1;
        $allocation->save();

        // Send email to Student
        Mail::to($proposal->student->email)->send(new ProposalAccept($proposal));
    }
    // Private rejected
    private function rejected(Request $request, Proposal $proposal){
        
    }
}
