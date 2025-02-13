<?php

namespace PixelWrap\Laravel;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Contracts\View\View;

class PixelWrapRenderer
{
    protected $theme = "tailwind";
    protected $paths = [];

    static function make($theme = "tailwind", $paths = []): static
    {
        return (new static)->setTheme($theme)->setPaths($paths);
    }

    /**
     * @throws \Exception
     */
    function render($page, $data = []): View
    {
        $pageContainer = config('pixelwrap.page-root');
        try {
            if(view()->exists($pageContainer)) {
                $nodes = $this->loadPage($page);
                if(is_object($nodes)) {
                    $nodes = [$nodes];
                }
            }else{
                raise(null, "The page-root view \"$pageContainer\" does not exist. Please check your config file \"config/pixelwrap.php\" and try again.");
            }
        } catch (ParseException $exception) {
            $errors     = [$exception->getMessage()];
            $component  = $this->loadFile($page);
            $nodes      = [(object) ["type" => "Exception"]];
            $data       = compact('errors', 'component');
        }
        return view('pixelwrap::page', ['theme' => $this->theme, 'pixelWrapContainer' => $pageContainer, 'nodes' => $nodes, ...$data]);
    }

    function loadPage($page)
    {
        return Yaml::parse($this->loadFile($page), Yaml::PARSE_OBJECT_FOR_MAP);
    }

    function loadFile($page)
    {
        if (file_exists($page)) {
            $file = $page;
        } else {
            foreach ($this->paths as $path) {
                $file = sprintf("%s/%s.yaml",$path, $page);
                if(file_exists($file)) {
                    break;
                }
            }
        }
        return mb_trim(file_get_contents($file));
    }

    public function setTheme(string $theme): static
    {
        $this->theme = $theme;
        return $this;
    }

    public function setPaths(array $paths): static
    {
        $this->paths = $paths;
        return $this;
    }
}
