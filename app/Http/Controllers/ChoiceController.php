<?php

namespace App\Http\Controllers;

use App\Choice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Auth::user()->role == "Student"){
            $choices = Choice::where('studentID', Auth::id())->orderBy('ranking')->get();
            return view('choices.index', ['choices' => $choices]);
        } else {
            return abort(403, "NOT ALLOWED");
        }
    }
}
