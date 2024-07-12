<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Traits\HasRoles;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /**  @var App\Modals\User */
        // if (Auth::check()) {
        //     $user = Auth::user();
        //     if ($user->hasRole(['super-admin', 'admin'])) {
        return $next($request);
        //     }
        //     abort(403, "User does not have correct Role");
        // }

        // abort(401);
    }
}
