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

        
        $user = Auth::user();
        // Get the roles associated with the user
        $roles = $user->getRoleNames();
        
        if ($roles[0] == 'Super Admin') {
            $redirecturl = '/admin/dashboard';
        } else if ($roles[0] == 'Delivery User') {
            $redirecturl = '/admin/orders';
        } else if ($roles[0] == 'Product Assembler') {
            $redirecturl = '/admin/assembler-order';
        } else if ($roles[0] == 'Accountant') {
            $redirecturl = '/admin/dashboard';
        } else if ($roles[0] == 'Admin') {
            $redirecturl = '/admin/dashboard';
        }else {
            $redirecturl = '/';
        }
        return redirect($redirecturl);

    }
}
