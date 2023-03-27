<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Cheslacki
 * Date: 26/03/2023
 * Time: 11:12
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/**
 * Class MenuHelper
 * @package App\Helpers
 */
class MenuHelper
{
    /**
     * @param $array
     * @return array
     */
    public static function getActive($array)
    {
        /**
         * @param $array
         * @param $route
         * @param null $callback
         * @return array
         */
        function arrayMapReverse($array, $route, $callback = null)
        {
            return array_map(function ($value) use ($route, $callback) {
                if (array_key_exists('route', $value) && $value['route'] == $route) {
                    $value['active'] = true;
                    if (is_callable($callback)) {
                        $callback(true);
                    }
                } else if (array_key_exists('sub_menu', $value) && is_array($value['sub_menu'])) {
                    $value['sub_menu'] = arrayMapReverse($value['sub_menu'], $route, function ($response) use (&$value, &$callback) {
                        $value['active'] = $response;
                        if (is_callable($callback)) {
                            $callback(true);
                        }
                    });
                }
                return $value;
            }, $array);
        }

        return arrayMapReverse($array, Route::currentRouteName());
    }

    /**
     * @return array
     */
    public static function getAdmin(){
        $array = [
            [
                'route' => null,
                'icon' => 'fa-user',
                'active' => false,
                'lang' => 'link.users',
                'sub_menu' => [
                    [
                        'route' => 'admin.users',
                        'icon' => null,
                        'active' => false,
                        'lang' => 'link.all_users'
                    ],
                    [
                        'route' => 'admin.user',
                        'icon' => null,
                        'active' => false,
                        'lang' => 'link.new_user'
                    ]
                ]
            ],
        ];

        return self::getActive($array);
    }

    /**
     * @return array
     */
    public static function get()
    {
        $current_user = AuthHelper::getCurrentUser();

        if ($current_user) {
            $method = ('get' . Str::ucfirst($current_user->role));
            if (method_exists(get_class(), $method)) {
                return self::$method();
            }
        }

        return [];
    }
}