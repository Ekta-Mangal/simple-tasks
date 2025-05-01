<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizationCheck
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role == 'User') {
            return back()->with("error", "User Unauthorized");
        }
        return $next($request);
    }
}