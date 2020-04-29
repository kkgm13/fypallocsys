<?php

namespace App\Http\Controllers;

use App\Proposal;
use App\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = null; $proposals = null;
        if(Auth::user()->role == "Module Leader"){
            // Module Leader Version
            $topics = Topic::all();
            $proposals = Proposal::latest()->get();
        } else if (Auth::user()->role == "Supervisor"){
            // Supervisor Version
            $topics = Topic::where('supervisorID', '=', Auth::id())->get();
            $proposals = Proposal::where('supervisorID', '=', Auth::id())->latest()->take(3)->get();
        } else {
            // Student Version
            $topics = null;
            $proposals = Proposal::where('studentID', '=', Auth::id())->latest()->take(3)->get();
            // if(!is_null(Auth::user()->allocation)){

            // } else {

            // }
        }
        return view('home', ['topics' => $topics, 'proposals' => $proposals]);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $messages = [
            'identity.required' => 'Email or username cannot be empty',
            'password.required' => 'Password cannot be empty',
        ];

        $request->validate([
            'identity' => 'required|string',
            'password' => 'required|string',
            'email' => 'string|exists:users',
            'username' => 'string|exists:users',
        ], $messages);
    }
}
