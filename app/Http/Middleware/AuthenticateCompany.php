<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateCompany extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('companylog');
        }
    }

    protected function authenticate($request, array $guards)
    {
        if ($this->auth->guard('company-api')->check() || $this->auth->guard('user-api')->check()) {
            return $this->auth->shouldUse('company-api');
        }
        $this->unauthenticated($request, ['company-api']);
    }

}
