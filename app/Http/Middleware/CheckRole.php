<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {

        // $user = $request->user()->hasRole("admin");
        // dd($role);
        if ($request->user()->hasRole($role)) { {
                return $next($request);
            }
        }
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        abort(403, 'Unauthorized :-(');
    }
}
