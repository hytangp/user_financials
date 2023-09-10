<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class AuthenticateApi
{
    public function handle($request, Closure $next, ...$guards)
    {
        if($this->authenticate($request, $guards)){
            return $next($request);
        }else{
            abort(401, 'Unauthorized');
        }
    }

    protected function authenticate($request, array $guards)
    {
        try {
            $result = Auth::guard('api')->check();
            return $result;
        } catch (AuthenticationException $exception) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }
}
