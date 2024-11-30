<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {

        $user = $request->user();
        echo $user;
        if (!$user || $user->role !== 'admin') {
            abort(403, 'you are not an admin');
        }
        return $next($request);
    }
}
