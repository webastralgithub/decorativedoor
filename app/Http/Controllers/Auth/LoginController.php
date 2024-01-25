<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Attempt to log the user in
        if ($this->attemptLogin($request)) {
            // Check user's role and redirect accordingly
            return $this->authenticated($request, Auth::user())
                ?: redirect()->intended($this->redirectPath());
        }

        // If the login attempt was unsuccessful
        return $this->sendFailedLoginResponse($request);
    }

    protected function authenticated(Request $request, $user)
    {
        $role = $user->getRoleNames();
        
        if (($role[0] == 'Super Admin')) {
            $redirecturl = redirect()->route('dashboard');
        } else if ($role[0] == 'Accountant') {
            $redirecturl = redirect()->route('dashboard');
        } else if ($role[0] == 'Delivery User') {
            $redirecturl = redirect()->route('orders.index');
        } else if ($role[0] == 'Product Assembler') {
            $redirecturl = redirect()->route('order-assembler');
        } else if ($role[0] == 'Admin') {
            $redirecturl = redirect()->route('dashboard');
        } else {
            $redirecturl = '/'; // Redirect other users to the default home page
        }
        // Default redirect for other roles
        return redirect()->away($redirecturl->getTargetUrl());
    }



}
