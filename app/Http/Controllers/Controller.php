<?php

namespace App\Http\Controllers;

use App\Exceptions\ExceptionValidation;
use App\Helpers\AuthHelper;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @var
     */
    protected $dataResponse;

    /**
     * @var
     */
    protected $dataReturn;

    /**
     * @var
     */
    private $model;

    /**
     * @var
     */
    private $type;

    /**
     * @var
     */
    private $errors;

    /**
     * @var
     */
    private $validation;

    /**
     * @var
     */
    private $message;

    /**
     * @var
     */
    private $only;

    /**
     * @var
     */
    private $id;

    /**
     * @var
     */
    private $data;

    /**
     * @var
     */
    private $object;

    /**
     * @param $string
     */
    protected function setModelString($string)
    {
        if ($string && !empty($string)) {
            $this->model = $string;
        } else {
            $this->model = null;
        }
    }

    /**
     * @return bool
     */
    protected function getModelString()
    {
        if (!empty($this->model)) {
            return $this->model;
        }
        return false;
    }

    /**
     * @param $string
     */
    protected function setTypeString($string)
    {
        if ($string && !empty($string)) {
            $this->type = $string;
        }
    }

    /**
     * @return bool
     */
    protected function getTypeString()
    {
        if (!empty($this->type)) {
            return $this->type;
        }
        return false;
    }

    /**
     * @param $object
     * @param $key
     * @return bool
     */
    protected function setErrorObject($object, $key)
    {
        if (is_object($object) && !empty($key)) {
            $this->errors[$key] = $object;
            return true;
        }
        return false;
    }

    /**
     * @param $object
     */
    protected function addErrorObject($object)
    {
        if (is_object($object)) {
            foreach ($object as $key => $value) {
                $this->setErrorObject($value, $key);
            }
        }
    }

    /**
     * @return array|bool
     */
    protected function getErrorsObject()
    {
        if (is_array($this->errors) && count($this->errors) > 0) {
            return $this->errors;
        }
        return false;
    }

    /**
     * @param $array
     * @return bool
     */
    protected function setValidationArray($array)
    {
        if (is_array($array)) {
            $this->validation = $array;
            return true;
        }
        return false;
    }

    /**
     * @param $array
     */
    protected function addValidationArray($array)
    {
        if (is_array($array)) {
            $this->validation = array_merge_recursive($this->validation, $array);
        }
    }

    /**
     * @param $array
     */
    protected function modifyValidationArray($array)
    {
        if (is_array($array)) {
            $this->validation = array_merge($this->validation, $array);
        }
    }

    /**
     * @return array
     */
    protected function getValidationArray()
    {
        if (is_array($this->validation) && count($this->validation) > 0) {
            return $this->validation;
        }
        return [];
    }

    /**
     * @param $array
     * @return bool
     */
    protected function setMessageArray($array)
    {
        if (is_array($array)) {
            $this->message = $array;
            return true;
        }
        return false;
    }

    /**
     * @param $array
     */
    protected function addMessageArray($array)
    {
        if (is_array($array)) {
            $this->message = array_merge_recursive($this->message, $array);
        }
    }

    /**
     * @param $array
     */
    protected function modifyMessageArray($array)
    {
        if (is_array($array)) {
            $this->message = array_merge($this->message, $array);
        }
    }

    /**
     * @return array
     */
    protected function getMessageArray()
    {
        if (is_array($this->message) && count($this->message) > 0) {
            return $this->message;
        }
        return [];
    }

    /**
     * @param $array
     * @return bool
     */
    protected function setOnlyArray($array)
    {
        if (is_array($array)) {
            $this->only = $array;
            return true;
        }
        return false;
    }

    /**
     * @param $array
     */
    protected function addOnlyArray($array)
    {
        if (is_array($array)) {
            $this->only = array_merge_recursive($this->only, $array);
        }
    }

    /**
     * @param null $fields
     * @return array
     */
    protected function getOnlyArray($fields = null)
    {
        if (is_array($this->only) && count($this->only) > 0) {
            if (is_null($fields)) {
                return $this->only;
            } else {
                $temp = [];
                foreach ($fields as $value) {
                    if (isset($this->only[$value])) {
                        $temp[$value] = $this->only[$value];
                    }
                }
                return $temp;
            }
        }
        return [];
    }

    /**
     * @param $id
     * @return bool
     */
    protected function setId($id)
    {
        if (!empty($id) && (is_numeric($id) || is_array($id))) {
            $this->id = $id;
            return true;
        }
        $this->id = null;
        return false;
    }

    /**
     * @return array|bool
     */
    protected function getId()
    {
        if (!empty($this->id)) {
            return $this->id;
        }
        return false;
    }

    /**
     * @param $array
     * @return bool
     */
    protected function setDataArray($array)
    {
        if (is_array($array)) {
            $this->data = $array;
            return true;
        }
        return false;
    }

    /**
     * @param $array
     */
    protected function addDataArray($array)
    {
        if (is_array($array)) {
            $this->data = array_merge_recursive($this->data, $array);
        }
    }

    /**
     * @param $array
     */
    protected function modifyDataArray($array)
    {
        if (is_array($array)) {
            $this->data = array_merge($this->data, $array);
        }
    }

    /**
     * @return array|bool
     */
    protected function getDataArray()
    {
        if (is_array($this->data) && count($this->data) > 0) {
            return $this->data;
        }
        return false;
    }

    /**
     * @param $field
     * @return null
     */
    public function getFieldDataArray($field)
    {
        return (isset($this->data[$field]) && !empty($this->data[$field]) ? $this->data[$field] : null);
    }

    /**
     * @param null $key
     */
    protected function removeFieldDataArray($key = null)
    {
        if (!is_null($key)) {
            unset($this->data[$key]);
        }
    }

    /**
     * @param bool $destroy
     */
    protected function redefineDataArray($destroy = false)
    {
        if ($destroy) {
            $this->data = null;
        } else if (is_array($this->data) && count($this->data) > 0) {
            $this->data = [];
        }
    }

    /**
     * @param $object
     * @return bool
     */
    protected function setObject($object)
    {
        if (is_object($object)) {
            $this->object = $object;
            return true;
        }
        return false;
    }

    /**
     * @param $object
     * @param $key
     * @return bool
     */
    protected function addObject($object, $key)
    {
        if ((is_object($object) || is_array($object)) && !empty($key)) {
            $this->object[$key] = $object;
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function getObject()
    {
        if (is_object($this->object)) {
            return $this->object;
        }
        return false;
    }

    /**
     *
     */
    protected function destroyObject()
    {
        if (is_object($this->object)) {
            $this->object = null;
        }
    }

    /**
     * @param $callback
     * @param $key
     */
    private function validator($callback, $key)
    {
        $validator = Validator::make($this->getOnlyArray(), $this->getValidationArray(), $this->getMessageArray());

        if ($validator->fails()) {
            $this->setErrorObject($validator->errors(), $key);
        } else {
            $callback(true);
        }
    }

    /**
     * @return array
     */
    public function validateGlobal()
    {
        try {
            if (!$this->getModelString() || !$this->getTypeString()) {
                throw new Exception(__('Error, validate global.'));
            }

            $this->validator(function () {
            }, $this->getTypeString());

            if ($this->getErrorsObject()) {
                throw new ExceptionValidation(json_encode($this->getErrorsObject()));
            }

            $this->dataResponse = [
                'status' => true,
                'data' => $this->dataReturn
            ];
        } catch (ExceptionValidation  $e) {
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

    /**
     * @param $role
     * @return bool
     */
    protected function getCurrentUser($role = null)
    {
        return AuthHelper::getCurrentUser($role);
    }
}
