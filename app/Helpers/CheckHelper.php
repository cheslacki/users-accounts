<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Cheslacki
 * Date: 25/03/2023
 * Time: 15:26
 */

namespace App\Helpers;

use Illuminate\Http\Request;

/**
 * Class CheckHelper
 * @package App\Helpers
 */
class CheckHelper extends Helper
{
    /**
     * @param Request $request
     * @param $parameter
     * @param array $params
     * @param null $empty
     * @return mixed|null|string
     */
    public static function getNotEmpty(Request $request, $parameter, $params = [], $empty = null)
    {
        parent::setRequestValue(null);
        if ($request->exists($parameter) && !empty($request->get($parameter))) {
            if (count($params) > 0) {
                parent::extractArrayRecursive($request->get($parameter), $params, $empty);
                return parent::getRequestValue();
            } else if (!is_array($request->get($parameter))) {
                return !empty($request->get($parameter)) ? trim($request->get($parameter)) : $empty;
            } else {
                return $request->get($parameter);
            }
        } else {
            return $empty;
        }
    }
}