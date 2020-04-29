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

    /**
     * Display a listing of Unallocated Topic Resource
     * 
     * @return \Illuminate\Http\Response
     */
    public function unallocatedTopic(){
        if(Auth::user()->role === "Module Leader"){
            // Topics that haven't been taken by students
            $unallocTopics = Topic::whereNotExists(function($query){
                $query->select('*')
                ->from('allocations')
                ->whereRaw('topics.id = allocations.topicID')
                ->where('allocations.topicID', "<>", "topics");
            })
            ->get();
            // Student that doesn't have a topic
            $unallocStudents = User::where('role', "Student")
            ->where('username','<>', "Guest")
            ->whereNotExists(function($query){
                $query->select('*')
                ->from('allocations')
                ->whereRaw('users.id = allocations.studentID')
                ->where('allocations.studentID', "<>", "users");
            })->get();
            return view('allocations.index',['unallocTopics' => $unallocTopics, 'unallocStudents' => $unallocStudents]);
        } else {
            return abort(404, "Not Found");
        }
    }

    /**
     * Display a listing of Unallocated Students Resource
     * 
     * @return \Illuminate\Http\Response
     */
    public function unallocatedStudent(){
        if(Auth::user()->role === "Module Leader"){
            // Student that doesn't have a topic
            $unallocStudents = User::where('role', "Student")
            ->where('username','<>', "Guest")
            ->whereNotExists(function($query){
                $query->select('*')
                ->from('allocations')
                ->whereRaw('users.id = allocations.studentID')
                ->where('allocations.studentID', "<>", "users");
            })->get();
            return view('allocations.index',['unallocStudents' => $unallocStudents]);
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