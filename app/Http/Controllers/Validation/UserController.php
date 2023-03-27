<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Cheslacki
 * Date: 24/03/2023
 * Time: 15:43
 */

namespace App\Http\Controllers\Validation;

use App\Exceptions\ExceptionValidation;
use App\Helpers\CheckHelper;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use Exception;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers\Validation
 */
class UserController extends Controller
{
    /**
     * @param Request $request
     * @param array $enables
     * @return array
     */
    public function validateUser(Request $request, $enables = [])
    {
        try {
            $model = $this->getModelString();
            $type = $this->getTypeString();

            if (!$model) {
                throw new Exception(__('Error, validate user.'));
            }

            $this->setValidationArray([]);

            $this->setMessageArray([
                'name.required' => __('validation.required', ['attribute' => ('(' . __('label.name') . ')')]),
                'name.between' => __('validation.between.string', ['attribute' => ('(' . __('label.name') . ')')]),
                'email.required' => __('validation.required', ['attribute' => ('(' . __('label.email') . ')')]),
                'email.email' => __('validation.email', ['attribute' => ('(' . __('label.email') . ')')]),
                'email.unique' => __('validation.unique', ['attribute' => ('(' . __('label.email') . ')')]),
                'active.required' => __('validation.required', ['attribute' => ('(' . __('label.status') . ')')]),
                'password.required' => __('validation.required', ['attribute' => ('(' . __('label.password') . ')')]),
                'password.between' => __('validation.between.string', ['attribute' => ('(' . __('label.password') . ')')]),
                'password_confirm.required' => __('validation.required', ['attribute' => ('(' . __('label.confirm_password') . ')')]),
                'password_confirm.same' => __('validation.same', ['attribute' => ('(' . __('label.password') . ')'), 'other' => ('(' . __('label.confirm_password') . ')')]),

            ]);

            if (in_array('name', $enables)) {
                $this->addValidationArray([
                    'name' => 'required|string|between:3,128',
                ]);
            }

            if (in_array('email', $enables)) {
                $this->addValidationArray([
                    'email' => 'required|string|email|max:128'
                ]);
            }

            if (in_array('active', $enables)) {
                $this->addValidationArray([
                    'active' => 'required'
                ]);
            }

            $password = CheckHelper::getNotEmpty($request, $model, ['password'], false);

            if((!$this->getId() || ($this->getId() && $password)) && in_array('password', $enables)){
                $this->addValidationArray([
                    'password' => 'required|string|between:5,10',
                    'password_confirm' => 'required|string|same:password'
                ]);
            }

            /** @var object $user */
            $user = ($this->getId() ? User::query()->find($this->getId()) : null);

            $email = CheckHelper::getNotEmpty($request, $model, ['email'], null);

            if (!$user || ($user && $user->email <> $email)) {
                $this->modifyValidationArray([
                    'email' => 'required|string|email|max:128|unique:users'
                ]);
            }

            if ($type) {
                $this->setOnlyArray(CheckHelper::getNotEmpty($request, $model, [$type], []));
            } else {
                $this->setTypeString($model);
                $this->setOnlyArray(CheckHelper::getNotEmpty($request, $model, [], []));
            }

            $response = $this->validateGlobal();

            if (!$response['status']) {
                if (isset($response['errors'])) {
                    throw new ExceptionValidation(json_encode($response['errors']));
                } else {
                    throw new Exception($response['error']);
                }
            }

            $this->dataResponse = [
                'status' => true
            ];
        } catch (ExceptionValidation $e) {
            $this->dataResponse = [
                'status' => false,
                'errors' => json_decode($e->getMessage()),
                'code' => $e->getCode()
            ];
        } catch (Exception $e) {
            $this->dataResponse = [
                'status' => false,
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ];
        } finally {
            return $this->dataResponse;
        }
    }
}