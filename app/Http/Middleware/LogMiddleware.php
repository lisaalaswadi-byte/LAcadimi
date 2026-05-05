<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Login;
use Illuminate\Support\Facades\Auth;

class LogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
     if(!session()->has("student")){
        return redirect()->route("log");
     }
        return $next($request);
    }
}
