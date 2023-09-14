<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }
    public function handle($request, Closure $next)
    {
        // Check if the user is an administrator
        if ($request->user() && $request->user()->isAdmin()) {
            return $next($request);
        }

        // You can customize the response or redirection here
        return redirect()->route('dashboard')->with('error', 'Access denied. You must be an administrator.');
    }
}
