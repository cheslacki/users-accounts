<?php
/**
 * Created by PhpStorm.
 * User: Leonardo Cheslacki
 * Date: 24/03/2023
 * Time: 17:32
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class HelperServiceProvider
 * @package App\Providers
 */
class HelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        foreach (glob(app_path() . '/Helpers/*.php') as $filename) {
            if (file_exists($filename)) {
                /** @noinspection PhpIncludeInspection */
                require_once($filename);
            }
        }
    }
}