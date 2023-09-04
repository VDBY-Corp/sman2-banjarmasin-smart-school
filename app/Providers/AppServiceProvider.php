<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Facades\Setting as SettingFacade;
use App\Utils\Setting;

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
        
        // dd(SettingFacade::get('school.name'));
    }
}
