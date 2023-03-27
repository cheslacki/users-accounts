<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Cheslacki
 * Date: 24/03/2023
 * Time: 08:52
 */

namespace App\Http\Controllers\System\Auth;

use App\Exceptions\ExceptionValidation;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Validation\AuthController as ValidationAuthController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

/**
 * Class LoginController
 * @package App\Http\Controllers\System\Auth
 */
class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return int
     */
    public function updateAccess(Request $request)
    {
        $user = DB::table('users');
        return $user->where('id', Auth::id())->update([
            'last_access_at' => Carbon::now()->toDateTimeString(),
            'last_access_ip' => $request->getClientIp(),
            'last_access_agent' => $request->userAgent()
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getLogin()
    {
        $page = 'login';
        $title = __('Sign In');
        return view('system.auth.index', compact('page', 'title'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        try {
            $validationAuthController = (new ValidationAuthController());
            $validationAuthController->setModelString('auth');

            $response = $validationAuthController->validateLogin($request, [
                'email',
                'password'
            ]);

            if (!$response['status']) {
                if (isset($response['errors'])) {
                    $this->addErrorObject($response['errors']);
                } else {
                    throw new Exception($response['error']);
                }
            }

            if ($this->getErrorsObject()) {
                throw new ExceptionValidation(json_encode($this->getErrorsObject()));
            }

            if (!Auth::attempt($request->only('auth.email', 'auth.password')['auth'])) {
                throw new Exception(__('message.email_password'));
            }

            $this->dataResponse = [
                'status' => true,
                'message' => [
                    'title' => __('message.success_title'),
                    'text' => __('message.success_text')
                ],
                'data' => [
                    'auth' => $this->updateAccess($request)
                ]
            ];
        } catch (ExceptionValidation $e) {
            $this->dataResponse = [
                'status' => false,
                'message' => [
                    'title' => __('message.error_title'),
                    'text' => __('message.error_text')
                ],
                'errors' => json_decode($e->getMessage()),
                'code' => $e->getCode()
            ];
        } catch (Exception $e) {
            $this->dataResponse = [
                'status' => false,
                'message' => [
                    'title' => __('message.error_title'),
                    'text' => $e->getMessage()
                ],
                'errors' => '',
                'code' => $e->getCode()
            ];
        } finally {
            if ($this->dataResponse['status']) {
                /** @var object $current_user */
                $current_user = $this->getCurrentUser();

                if ($current_user) {
                    $this->dataResponse['route'] = route("{$current_user->role}.users");
                    return Response::json($this->dataResponse);
                } else {
                    return $this->getLogout();
                }
            } else {
                return Response::json($this->dataResponse);
            }
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        /* Correct is 'home', 'login' for test. */
        return Redirect::route('login');
    }
}