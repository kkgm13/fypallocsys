<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if(Auth::user()->role != 'Student'){
            return view('users.edit', ['user' => $user]);
        } else {
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if(Auth::user()->role != "Student"){
            $validateData = $request->validate([
                'bio' => 'nullable|string',
            ]);

            $user->update($validateData);

            return redirect()->route('home')->with(['type' => 'success', 'status' => 'Your profile has been updated']);
        } else {
            return abort(401);
        }
    }
}
