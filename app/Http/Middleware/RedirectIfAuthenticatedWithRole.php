<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedWithRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $role = auth()->user()->role;

            if ($role === 'Admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($role === 'Employee') {
                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}
