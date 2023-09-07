<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Facades\Setting as SettingFacade;
use App\Utils\Setting;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Utils/funcs.php');

        // register setting facade
        $this->app->singleton('setting', function () {
            return new Setting();
        });

        // check if request from https
        // get current link
        $currentLink = request()->fullUrl();

        // if url containts ngrok, force https
        if (strpos($currentLink, 'ngrok') !== false) {
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // load settings
        if (!app()->runningInConsole()) {
            SettingFacade::load();
        }

        app()->setLocale('id');
    }
}
