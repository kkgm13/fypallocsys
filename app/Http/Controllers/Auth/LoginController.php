<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {

        // Get HTTP Request Input
        $login = request()->input('identity');
        // Filter the Value to get either the email/username
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        // Merge the request 
        request()->merge([$field => $login]);
        
        return $field;
        // return 'email';
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateLogin(Request $request)
    {
        $messages = [
            'identity.required' => 'Email or username cannot be empty',
            'email.exists' => 'Email or username cannot be empty',
            'username.exists' => 'Email or username cannot be empty',
            'password.required' => 'Password cannot be empty',
        ];

        $this->validate($request, [
            'identity' => 'required|string',
            'password' => 'required|string',
            'email' => 'string|exists:users',
            'username' => 'string|exists:users',
        ], $messages);
    }
}
