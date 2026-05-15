<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()){
            return redirect()->route('login');
        }

        if (in_array(Auth::user()->role, $roles)) {
        return $next($request);
        }
        abort(403, 'Доступ запрещён');
    }
}
