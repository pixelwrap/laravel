<?php

namespace PixelWrap\Laravel;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class PixelWrapServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->singleton('pixelwrap', function ($app) {
            return PixelWrapRenderer::make($app->config->get('pixelwrap.theme'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::addNamespace("pixelwrap", [pixelwrap_resource()]);
    }
}
