<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Cheslacki
 * Date: 24/03/2023
 * Time: 08:58
 */

namespace App\Http\Controllers\Validation;

use App\Exceptions\ExceptionValidation;
use App\Helpers\CheckHelper;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

/**
 * Class AuthController
 * @package App\Http\Controllers\Validation
 */
class AuthController extends Controller
{

    /**
     * @param Request $request
     * @param array $enables
     * @return array
     */
    public function validateLogin(Request $request, $enables = [])
    {
        try {
            $model = $this->getModelString();
            $type = $this->getTypeString();

            if (!$model) {
                throw new Exception(__('Error, validate login.'));
            }

            $this->setValidationArray([]);

            $this->setMessageArray([
                'password.required' => __('validation.required', ['attribute' => ('(' . __('label.password') . ')')]),
                'email.required' => __('validation.required', ['attribute' => ('(' . __('label.email') . ')')]),
                'email.email' => __('validation.email', ['attribute' => ('(' . __('label.email') . ')')])
            ]);

            if (in_array('email', $enables)) {
                $this->addValidationArray([
                    'email' => 'required|string|email'
                ]);
            }

            if (in_array('password', $enables)) {
                $this->addValidationArray([
                    'password' => 'required|string'
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