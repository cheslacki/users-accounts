<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Cheslacki
 * Date: 27/03/2023
 * Time: 00:16
 */

namespace App\Helpers;

/**
 * Class QueryHelper
 * @package App\Helpers
 */
class QueryHelper
{
    /**
     * @return array
     */
    public static function getActive()
    {
        return [
            'yes' => __('text.status.yes'),
            'no' => __('text.status.no')
        ];
    }

}