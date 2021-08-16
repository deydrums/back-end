<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ... $roles)
    {
        
        $user = Auth::user();

        foreach($roles as $role) {
            if($user->role === $role){
                return $next($request);
            }else{
                return response()->json([
                    'ok' => false,
                    'message' => __('api-auth.no_role'),
                ], 401);
            }
        }
    }
}
