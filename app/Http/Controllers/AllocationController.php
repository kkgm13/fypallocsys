<?php

namespace App\Http\Controllers;

use App\Allocation;
use App\Proposal;
use App\Topic;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllocationController extends Controller
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
    public function index(){
        $allocation = null;
        if(Auth::user()->role === "Student"){
            $allocation = Allocation::where('studentID', Auth::id())->first();
        } else if(Auth::user()->role == "Supervisor"){
            $allocation = Allocation::where('supervisorID', Auth::id())->get();
        } else {
            $allocation = Allocation::with(['student', 'supervisor', 'topic', 'proposal'])->get();
        }
        return view('allocations.index', ['allocation' => $allocation]);
    }

    public function unallocated(){
        if(Auth::user()->role === "Module Leader"){
            $unalloc = User::leftJoin('allocations', 'users.id', '=', 'allocations.studentID')
                ->where('role', "Student")
                
                ->get();
            dd($unalloc);
        } else {
            return abort(404, "Not Found");
        }
    }

    /**
     * Store a newly selected choice in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Proposal $proposal = null, Topic $topic = null){
        $allocation = new Allocation();
        if(is_null($proposal)){
            $allocation->topicID = $topic->id;
        } elseif(is_null($topic)){
            $allocation->proposalID = $proposal->id;
        }
        $allocation->supervisorID = Auth::id();
        $allocation->studentID = $proposal->student->id;
        $allocation->superAuth = 1;
        $allocation->save();
        return $allocation;
    }
}