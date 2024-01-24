<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

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

    protected function redirectTo()
    {
        $user = Auth::user();

        if (($user->hasRole('Super Admin'))) {
            $redirecturl = '/admin/dashboard';
        } elseif ($user->hasRole('Accountant')) {
            $redirecturl = '/admin/dashboard';
        } elseif ($user->hasRole('Delivery User')) {
            $redirecturl = '/admin/orders';
        } elseif ($user->hasRole('Product Assembler')) {
            $redirecturl = '/admin/assembler-order';
        } elseif ($user->hasRole('Admin')) {
            $redirecturl = '/admin/dashboard';
        } else {
            $redirecturl = '/'; // Redirect other users to the default home page
        }
        return redirect($redirecturl);
    }
}
