<?php

namespace PixelWrap\Laravel;

use Exception;
use PixelWrap\Laravel\Components\Button;
use PixelWrap\Laravel\Components\Column;
use PixelWrap\Laravel\Components\ComponentContract;
use PixelWrap\Laravel\Components\Form;
use PixelWrap\Laravel\Components\Grid;
use PixelWrap\Laravel\Components\Heading;
use PixelWrap\Laravel\Components\HorizontalRuler;
use PixelWrap\Laravel\Components\Input;
use PixelWrap\Laravel\Components\PlaceHolder;
use PixelWrap\Laravel\Components\Row;
use PixelWrap\Laravel\Components\Table;
use PixelWrap\Laravel\Components\TypeAhead;
use PixelWrap\Laravel\Support\NodeNotImplemented;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Contracts\View\View;

class PixelWrapRenderer
{
    protected $theme = "tailwind";
    protected $paths = [];
    static $map = [
        'heading'   =>  Heading::class,
        'button'    =>  Button::class,
        'column'    =>  Column::class,
        'row'       =>  Row::class,
        'grid'      =>  Grid::class,
        'hr'        =>  HorizontalRuler::class,
        'form'      =>  Form::class,
        'table'     =>  Table::class,
        'input'     =>  Input::class,
        'typeahead' =>  TypeAhead::class,
        null        =>  PlaceHolder::class,
        'horizontalruler' =>  HorizontalRuler::class,
    ];

    static function make($theme = "tailwind", $paths = []): static
    {
        return (new static)->setTheme($theme)->setPaths($paths);
    }

    /**
     * @throws NodeNotImplemented
     */
    static function from($data, $component, $theme): ComponentContract
    {
        $nodeName= mb_strtolower($component->type);
        if(isset(static::$map[$nodeName])) {
            return new (static::$map[$nodeName])($data, $component, $theme);
        }else{
            throw new NodeNotImplemented(sprintf("Node \"%s\" is not implemented.", mb_ucfirst($component->type)));
        }
    }

    /**
     * @throws Exception
     */
    function render($page, $data = []): View
    {
        $pageContainer = config('pixelwrap.page-root');
        try {
            if(view()->exists($pageContainer)) {
                $nodes = $this->loadPage($page);
                $components = [];
                foreach ($nodes as $node) {
                    $components[] = static::from($data, $node, $this->theme);
                }
            }else{
                raise(null, "The page-root view \"$pageContainer\" does not exist. Please check your config file \"config/pixelwrap.php\" and try again.");
            }
        } catch (ParseException $exception) {
            $errors     = [$exception->getMessage()];
            $component  = $this->loadFile($page);
            $components = [(object) ["type" => "Exception"]];
            $data       = compact('errors', 'component');
        }
        return view('pixelwrap::page', compact('components', 'pageContainer', 'data'));
    }

    function loadPage($page)
    {
       $nodes = Yaml::parse($this->loadFile($page), Yaml::PARSE_OBJECT_FOR_MAP);
        if(is_object($nodes)) {
            $nodes = [$nodes];
        }
        return $nodes;
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
