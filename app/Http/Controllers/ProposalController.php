<?php

namespace App\Http\Controllers;

use App\Allocation;
use App\Mail\AllocatedLetter;
use App\Mail\ProposalAccept;
use App\Mail\ProposalReject;
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
            return redirect()->route('proposals.index')->with([
                'status' => "Your $proposal->name proposal has been successfully sent off to the proposed supervisor",
                'type' => 'success',
            ]);
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
        if($proposal->studentID === Auth::id() || $proposal->supervisorID === Auth::id()){
            // If Proposed Supervisor is reviewing for the first time, update hasRead
            if($proposal->supervisorID === Auth::id() && $proposal->hasRead === 0){
                $proposal->update(['hasRead' => 1]);
            }
            return view('proposals.show', ['proposal' => $proposal]);
        } else {
            return abort(403, "Forbidden");
        }
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
        if(Auth::id() == $proposal->supervisorID){
            $aloCheck = Allocation::where('studentID', $proposal->student->id)->get();
            //If already allocated a topic
            if(!$aloCheck->isEmpty()){
                // Message User with an allocation provided
                return redirect()->back()->with([
                    'status' => 'Student has been already allocated an Topic',
                    'type' => 'warning'
                ]);
            } else {
                $request->decision === "accepted" ? $this->accepted($request, $proposal) : $this->rejected($request, $proposal);
                return redirect()->route('proposals.index')->with([
                    'status' => "Proposal has been $request->decision. The system is informing the student.",
                    'type' => 'success',
                ]);   
            }
        } else {
            return abort(403, "Forbidden");
        }
    }

    /**
     * Proposal has been accepted
     * 
     * @param Request Request
     * @param Proposal Proposal Data
     */
    private function accepted(Request $request, Proposal $proposal){
        $allocation = (new AllocationController)->store($request, $proposal);
        // Send email to Student
        // Intelesense throws this as an error for some reason
        Mail::to($proposal->student->email)->send(new AllocatedLetter($allocation));
    }
    
    /**
     * Proposal has been Rejected
     * 
     * @param Request Request
     * @param Proposal Proposal Data
     */
    private function rejected(Request $request, Proposal $proposal){
        $proposal->update(['hasRejected' => 1]);
        // Send Email to student
        Mail::to($proposal->student->email)->send(new ProposalReject($proposal, null));
    }
}
