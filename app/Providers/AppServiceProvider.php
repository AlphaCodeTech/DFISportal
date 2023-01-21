<?php

namespace App\Providers;

use App\Models\Parents;
use Illuminate\Support\Facades\Blade;
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
    public function boot()
    {
        Blade::directive('parent', function () {
            $isAuth = false;
            if (auth()->user() instanceof Parents) {
                dd('ok');
                $isAuth = true;
            }

            return "<?php if (" . intval($isAuth) . ") { ?>";
        });

        Blade::directive('endparent', function () {
            return "<?php } ?>";
        });
    }
}
