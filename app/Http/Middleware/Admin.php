<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Cheslacki
 * Date: 24/03/2023
 * Time: 17:03
 */

namespace App\Http\Middleware;

use App\Helpers\AuthHelper;
use Closure;
use Illuminate\Support\Facades\Redirect;

/**
 * Class Admin
 * @package App\Http\Middleware
 */
class Admin
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param Closure $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var object $current_user */
        $current_user = AuthHelper::getCurrentUser('admin');

        if ($current_user && $current_user->role == 'admin') {
            $pages = [
                'admin.user',
                'admin.users',
                'admin.user.post',
                'admin.user.delete'
            ];
        }

        if (isset($pages) && in_array($request->route()->getName(), $pages)) {
            return $next($request);
        }

        return Redirect::route('404');
    }
}