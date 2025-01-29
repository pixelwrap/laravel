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
        $this->mergeConfigFrom(__DIR__ . '/../config/pixelwrap.php', 'pixelwrap');

        app()->singleton('pixelwrap', function ($app) {
            return PixelWrapRenderer::make($app->config->get('pixelwrap.theme'), $app->config->get('pixelwrap.resources'));
        });

        app()->singleton(PixelWrapRenderer::class, function ($app) {
            return $app->make('pixelwrap');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->publishes([__DIR__ . '/../config/pixelwrap.php' => config_path('pixelwrap.php')]);
        View::addNamespace("pixelwrap", [pixelwrap_resource()]);
    }
}
