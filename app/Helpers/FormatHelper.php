<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Cheslacki
 * Date: 26/03/2023
 * Time: 11:47
 */

namespace App\Helpers;

/**
 * Class FormatHelper
 * @package App\Helpers
 */
class FormatHelper extends Helper
{
    /**
     * @param $string
     * @param string $delimiter
     * @return array
     */
    public static function formatStringToArray($string, $delimiter = ' ')
    {
        if ($string) {
            $count_delimiter = substr_count($string, $delimiter);
            if ($count_delimiter > 0) {
                $string = array_values(array_filter(explode($delimiter, trim($string)), function ($value) {
                    return $value != '';
                }));
            }
        }
        return $string;
    }

    /**
     * @param $string
     * @return mixed|string
     */
    public static function formatInitials($string)
    {
        if ($string) {
            $array = self::formatStringToArray($string);
            if (is_array($array)) {
                foreach ($array as $key => $value) {
                    if (strlen($value) > 0 && $key == 0 || strlen($value) > 0 && $key == 1) {
                        $array[$key] = mb_strtoupper(substr($value, 0, 1));
                    } else {
                        unset($array[$key]);
                    }
                }
                $string = implode('', $array);
            } else if (is_string($array) && strlen($array) > 0) {
                $string = mb_strtoupper(substr($array, 0, 1));
            }
        }
        return $string;
    }

    /**
     * @param int $length
     * @return string
     */
    public static function randomString($length = 6)
    {
        $str = '';
        $letters = array_merge(
            range('A', 'Z'),
            range('0', '9')
        );
        $max = count($letters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $letters[$rand];
        }
        return $str;
    }

    /**
     * @param $array
     * @param null $prefix
     * @return string
     */
    public static function arrayToParams($array, $prefix = null)
    {
        if (!is_array($array)) {
            return $array;
        }

        $params = [];

        foreach ($array as $k => $v) {
            if (is_null($v)) {
                continue;
            }

            if ($prefix && $k && !is_int($k)) {
                $k = $prefix . '[' . $k . ']';
            } else if ($prefix) {
                $k = $prefix . '[]';
            }

            if (is_array($v)) {
                $params[] = self::arrayToParams($v, $k);
            } else {
                $params[] = $k . '=' . urlencode($v);
            }
        }

        return implode('&', $params);
    }
}