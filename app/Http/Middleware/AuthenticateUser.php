<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateUser extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) 
        {
            return route('userlog');
        }
    }

    protected function authenticate($request, array $guards)
    {
        if ($this->auth->guard('user-api')->check()) 
        {
            return $this->auth->shouldUse('user-api');
        }
        $this->unauthenticated($request, ['user-api']);
    }

}
