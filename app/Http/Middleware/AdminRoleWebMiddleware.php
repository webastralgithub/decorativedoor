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
        // $allowedRoles = ['Super Admin', 'Delivery User', 'Product Assembler', 'Accountant', 'Admin', 'Sales Person', 'Order Coordinator', 'Project Manager'];

        // if (auth()->check() && auth()->user()->hasAnyRole($allowedRoles)) {
        //     return redirect('/admin');
        // }
    
        // return $next($request);
       
        if (auth()->check() && (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Delivery User') || auth()->user()->hasRole('Product Assembler') || auth()->user()->hasRole('Accountant') || auth()->user()->hasRole('Admin'))) {
            return redirect('/admin');
        }else if(auth()->user()->hasRole('Sales Person')){
            return $next($request);
        }

        return redirect('/');
        
    }
}
