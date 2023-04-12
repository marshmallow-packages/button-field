<?php

namespace Marshmallow\ButtonField;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::middleware(['nova'])
            ->prefix('nova-vendor/button-field')
            ->group(__DIR__ . '/routes.php');

        Nova::serving(function (ServingNova $event) {
            Nova::script('button-field', __DIR__ . '/../dist/js/field.js');
            Nova::style('button-field', __DIR__ . '/../dist/css/field.css');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
