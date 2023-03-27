<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Cheslacki
 * Date: 26/03/2023
 * Time: 19:18
 */

namespace App\Helpers;

/**
 * Class InfoHelper
 * @package App\Helpers
 */
class InfoHelper
{
    /**
     * @param string $space
     * @param string $disk
     * @return string
     */
    public static function getDiskSpace($space = 'total', $disk = 'C:')
    {
        $base = 1024;
        $si_prefix = ['B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB'];

        if ($space == 'free') {
            $bytes = disk_free_space($disk);
        } else {
            $bytes = disk_total_space($disk);
        }

        $class = min((int)log($bytes, $base), count($si_prefix) - 1);
        return sprintf('%1.2f %s', ($bytes / pow($base, $class)), $si_prefix[$class]);
    }
}