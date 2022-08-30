<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
	/***login with email or username ***/
	    public function login(Request $request)

    {   

        $input = $request->all();
       /*** validation ***/
        $this->validate($request, [

            'name' => 'required',

            'password' => 'required',

        ]);

  
/*** check input type if email or name to login with it  ***/
        $fieldType = filter_var($request->name, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if(auth()->attempt(array($fieldType => $input['name'], 'password' => $input['password'])))

        {

            return redirect()->route('home');

        }else{

            return redirect()->route('login')

                ->with('error','User name And Password Are Wrong.');

        }
	}
}
