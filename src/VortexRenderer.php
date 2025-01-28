<?php

namespace Vortex\Laravel;

use Symfony\Component\Yaml\Yaml;
use Illuminate\Contracts\View\View;
use Vortex\Laravel\Support\InvalidPropertyValue;

class VortexRenderer
{
    protected $theme = "tailwind";

    static function make($theme = "tailwind"): static
    {
        return (new static)->setTheme($theme);
    }

    function render($page, $data = []): View
    {
        $pageContainer = config('vortex.page-root');
        $nodes = $this->loadVortexPage($page);
        try {
            return view('vortex::page', ['theme' => $this->theme, 'vortexContainer' => $pageContainer, 'nodes' => $nodes, ...$data]);
        } catch (InvalidPropertyValue $exception) {
            return view('vortex::exception', ['exception' => $exception]);
        }
    }

    function loadVortexPage($page)
    {
        if (file_exists($page)) {
            $file = $page;
        } else {
            $file = resource_path(sprintf("vortex/%s.yaml", $page));
        }
        return Yaml::parse(file_get_contents($file), Yaml::PARSE_OBJECT_FOR_MAP);
    }

    public function setTheme(string $theme): static
    {
        $this->theme = $theme;
        return $this;
    }
}
