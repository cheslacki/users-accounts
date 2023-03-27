<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Cheslacki
 * Date: 26/03/2023
 * Time: 07:58
 */

namespace App\Http\Controllers\System\Auth;

use App\Http\Controllers\Controller;

/**
 * Class ForgotPasswordController
 * @package App\Http\Controllers\System\Auth
 */
class ForgotPasswordController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getForgotPassword()
    {
        $page = 'forgot-password';
        $title = __('title.forgot_password');
        return view('system.auth.index', compact('page', 'title'));
    }
}