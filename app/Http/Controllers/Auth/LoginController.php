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

    public function redirectTo()
    {
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('Super Admin')) {
            return '/admin/dashboard';
        } else if ($user->hasRole('Delivery User')) {
            return '/admin/dashboard';
        } else if ($user->hasRole('Product Assembler')) {
            return '/admin/dashboard';
        } else if ($user->hasRole('Accounted')) {
            return '/admin/dashboard';
        } else {
            return '/';
        }
    }
}
