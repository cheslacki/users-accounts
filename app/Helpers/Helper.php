<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Cheslacki
 * Date: 24/03/2023
 * Time: 17:05
 */

namespace App\Helpers;

/**
 * Class Helper
 * @package App\Helpers
 */
class Helper
{
    /**
     * @var null
     */
    private static $request_value = null;

    /**
     * @param $value
     */
    protected static function setRequestValue($value)
    {
        self::$request_value = !empty($value) && !is_array($value) ? trim($value) : $value;
    }

    /**
     * @return null
     */
    protected static function getRequestValue()
    {
        return self::$request_value;
    }

    /**
     * @param $array
     * @param $params
     * @param $empty
     */
    protected static function extractArrayRecursive($array, $params, $empty)
    {
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                if (isset($array[$key])) {
                    self::extractArrayRecursive($array[$key], $value, $empty);
                } else {
                    break;
                }
            } else if (isset($array[$value]) && !empty($array[$value])) {
                self::setRequestValue($array[$value]);
            } else {
                self::setRequestValue($empty);
            }
            break;
        }
    }
}