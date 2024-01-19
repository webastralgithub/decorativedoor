<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminRoleWebMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        if (auth()->check() && (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Delivery User') || auth()->user()->hasRole('Product Assembler') || auth()->user()->hasRole('Accountant') || auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Sales Person'))) {
            return $next($request);
        }

        return redirect('/');
        
    }
}
