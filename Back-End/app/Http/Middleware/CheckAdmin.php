<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;



class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $tokenData = DB::table('personal_access_tokens')->where('token', $token)->first();

        if ($tokenData) {
            $tokenableId = $tokenData->tokenable_id;
            $tokenableType = $tokenData->tokenable_type;

            $tokenable = null;
            if ($tokenableType === 'App\Models\User') {
                $tokenable = User::find($tokenableId);
            }

            if ($tokenable) {
                $userName = $tokenable->name;
                $userId = $tokenable->id;

                if (!$tokenable) {
                    abort(403, 'there is no User !!!!!');
                }
                if (!$tokenable || $tokenable->role !== 'admin') {
                    abort(403, $tokenable);
                }
            }
        }
        return $next($request);
    }
}
