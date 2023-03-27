<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Cheslacki
 * Date: 24/03/2023
 * Time: 17:14
 */

namespace App\Http\Middleware;

use App\Helpers\AuthHelper;
use Closure;
use Illuminate\Support\Facades\Redirect;

/**
 * Class Unauthenticated
 * @package App\Http\Middleware
 */
class Unauthenticated
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
            return Redirect::route("{$current_user->role}.users");
        }

        return $next($request);
    }
}