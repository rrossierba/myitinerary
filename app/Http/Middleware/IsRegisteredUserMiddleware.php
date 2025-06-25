<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsRegisteredUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ((!auth()->check())||(auth()->user()->role!='registered_user')) {
            return response()->view('errors.403', ['message' => 'Only registered users can access this page!'], 403);
        }
        return $next($request);
    }
}
