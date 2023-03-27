<?php

namespace App\Http\Middleware;

use App\Helpers\AuthHelper;
use Closure;
use Illuminate\Support\Facades\Redirect;

/**
 * Class Authenticate
 * @package App\Http\Middleware
 */
class Authenticate
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var object $current_user */
        $current_user = AuthHelper::getCurrentUser();

        if ($current_user && $current_user->hasVerifiedEmail()) {
            return $next($request);
        }

        return Redirect::route('login');
    }
}
