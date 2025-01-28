<?php

namespace PixelWrap\Laravel;

use Symfony\Component\Yaml\Yaml;
use Illuminate\Contracts\View\View;
use PixelWrap\Laravel\Support\InvalidPropertyValue;

class PixelWrapRenderer
{
    protected $theme = "tailwind";

    static function make($theme = "tailwind"): static
    {
        return (new static)->setTheme($theme);
    }

    function render($page, $data = []): View
    {
        $pageContainer = config('pixelwrap.page-root');
        $nodes = $this->loadPage($page);
        try {
            return view('pixelwrap::page', ['theme' => $this->theme, 'pixelWrapContainer' => $pageContainer, 'nodes' => $nodes, ...$data]);
        } catch (InvalidPropertyValue $exception) {
            return view('vortex::exception', ['exception' => $exception]);
        }
    }

    function loadPage($page)
    {
        if (file_exists($page)) {
            $file = $page;
        } else {
            $file = resource_path(sprintf("pixelwrap/%s.yaml", $page));
        }
        return Yaml::parse(file_get_contents($file), Yaml::PARSE_OBJECT_FOR_MAP);
    }

    public function setTheme(string $theme): static
    {
        $this->theme = $theme;
        return $this;
    }
}
