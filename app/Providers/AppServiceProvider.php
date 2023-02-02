<?php

namespace App\Providers;

use App\Models\Parents;
use App\Settings\AcademicSetting;
use App\Settings\SystemSetting;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(SystemSetting $systemSetting,AcademicSetting $academicSetting)
    {
        $appSettings = $systemSetting;
        $aSettings = $academicSetting;
        View::share(['appSettings'=> $appSettings,'aSettings'=> $aSettings]); 
    }
}
