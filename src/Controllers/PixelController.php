<?php

namespace PixelWrap\Laravel\Facades\Controllers;

use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use PixelWrap\Laravel\Facades\PixelWrapRenderer;

class PixelController extends Controller
{
    protected $prefix = "";
    protected $resources;

    public function __construct(protected PixelWrapRenderer $pixel) {}
    /**
     * @param string $page
     * @param array $data
     * @param array $options
     */
    public function render($page, $data = [], $options = []): View
    {
        if (Str::length($this->prefix) > 1) {
            $prefix = sprintf("%s/", Str::rtrim($this->prefix, "/"));
        } else {
            $prefix = "";
        }
        $path = sprintf("%s%s/%s", $prefix, $this->resources, $page);
        return $this->pixel->renderPage($path, $data, $options);
    }
    /**
     * @param string $route
     * @param mixed $params
     * @param int $status
     * @param array $headers
     */
    public function route($route, $params = [], $status = 302, $headers = []): RedirectResponse
    {
        return redirect()->action([static::class, $route], $params, $status, $headers);
    }
}
