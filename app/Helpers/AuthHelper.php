<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Cheslacki
 * Date: 24/03/2023
 * Time: 17:05
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

/**
 * Class AuthHelper
 * @package App\Helpers
 */
class AuthHelper extends Helper
{
    /**
     * @param null $role
     * @return bool|object
     */
    public static function getCurrentUser($role = null)
    {
        if (Auth::check()) {
            /** @var object $user */
            $user = Auth::user();
            if (($user->active == 'yes') && (($role && $role == $user->role) || !$role)) {
                return $user;
            }
        }

        return false;
    }

    /**
     * @param null|object $current_user
     * @return string
     */
    public static function getAvatar($current_user = null)
    {
        /* Here algorithm for check '$current_user->profile->avatar'. */
        return 'images/user.png';
    }
}