<?php

namespace Vortex\Laravel;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class VortexServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->singleton('vortex', function ($app) {
            return VortexRenderer::make($app->config->get('vortex.theme'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::addNamespace("vortex", [vortex_resource()]);
    }
}
