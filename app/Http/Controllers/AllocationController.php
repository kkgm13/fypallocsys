<?php

namespace App\Http\Controllers;

use App\Allocation;
use Illuminate\Support\Facades\Auth;

class AllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role === "Student"){
            $allocation = Allocation::where('studentID', Auth::id())->get();
        } else {
            $allocation = Allocation::where('supervisorID', Auth::id())->get();
        }
    }
}
