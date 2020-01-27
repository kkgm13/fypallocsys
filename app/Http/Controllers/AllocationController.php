<?php

namespace App\Http\Controllers;

use App\Allocation;
use App\Proposal;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if(Auth::user()->role === "Student"){
            $allocation = Allocation::where('studentID', Auth::id())->get();
        } else {
            $allocation = Allocation::where('supervisorID', Auth::id())->get();
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
    }
    
}
