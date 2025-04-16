<?php

namespace PixelWrap\Laravel;

use Illuminate\Support\Facades\Blade;
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

        app()->bind('pixelwrap', function ($app) {
            return PixelWrapRenderer::make($app->config->get('pixelwrap.theme'), $app->config->get('pixelwrap.resources'), $app->config->get('pixelwrap.rounded'));
        });

        app()->bind(PixelWrapRenderer::class, function ($app) {
            return $app->make('pixelwrap');
        });

        Blade::directive('pixelicon', function ($expression) {
            return "<?php echo pixel_insert_icon($expression); ?>";
        });

        Blade::directive('pixelwrap', function ($expression) {
            return "<?php echo pixelwrap()->render($expression); ?>";
        });

        Blade::directive('pixelcomponent', function ($expression) {
            return "<?php echo pixelwrap()->renderComponent($expression); ?>";
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
