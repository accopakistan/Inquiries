<?php

namespace App\Providers;

use App\Models\ProjectType;
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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('sidebarProjectTypes', ProjectType::all());
        });

        // Add custom blade directive for robust asset pathing across XAMPP and artisan serve
        \Illuminate\Support\Facades\Blade::directive('modernAsset', function ($expression) {
            return "<?php 
                \$path = $expression;
                \$entryDir = basename(dirname(\$_SERVER['SCRIPT_FILENAME']));
                \$isPublicRoot = (\$entryDir === 'public');
                echo asset(\$isPublicRoot ? \$path : 'public/' . \$path);
            ?>";
        });
    }
}
