<?php

namespace PixelWrap\Laravel\Facades;

use Illuminate\Support\Facades\Facade as BaseFacade;

/**
 * @method static \Illuminate\Contracts\View\View renderPage(string $view, \Illuminate\Contracts\Support\Arrayable|array $data = [], array $mergeData = [])
 *
 * @see \Illuminate\View\Factory
 */
class PixelWrap extends BaseFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'pixelwrap';
    }
}
