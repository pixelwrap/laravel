<?php

namespace PixelWrap\Laravel;

use Exception;
use PixelWrap\Laravel\Facades\Components\Badge;
use PixelWrap\Laravel\Facades\Components\Button;
use PixelWrap\Laravel\Facades\Components\Column;
use PixelWrap\Laravel\Facades\Components\ComponentContract;
use PixelWrap\Laravel\Facades\Components\Form;
use PixelWrap\Laravel\Facades\Components\Image;
use PixelWrap\Laravel\Facades\Components\Navbar;
use PixelWrap\Laravel\Facades\Components\Sidebar;
use PixelWrap\Laravel\Facades\Components\Progress;
use PixelWrap\Laravel\Facades\Components\Tab;
use PixelWrap\Laravel\Facades\Components\Tabs;
use PixelWrap\Laravel\Facades\Components\TextArea;
use PixelWrap\Laravel\Facades\Components\Grid;
use PixelWrap\Laravel\Facades\Components\Card;
use PixelWrap\Laravel\Facades\Components\Listing;
use PixelWrap\Laravel\Facades\Components\Text;
use PixelWrap\Laravel\Facades\Components\Heading;
use PixelWrap\Laravel\Facades\Components\HorizontalRuler;
use PixelWrap\Laravel\Facades\Components\Input;
use PixelWrap\Laravel\Facades\Components\PlaceHolder;
use PixelWrap\Laravel\Facades\Components\Row;
use PixelWrap\Laravel\Facades\Components\Select;
use PixelWrap\Laravel\Facades\Components\Table;
use PixelWrap\Laravel\Facades\Components\Timeline;
use PixelWrap\Laravel\Facades\Components\Toggle;
use PixelWrap\Laravel\Facades\Components\TypeAhead;
use PixelWrap\Laravel\Facades\Components\Modal;
use PixelWrap\Laravel\Facades\Support\NodeNotImplemented;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Contracts\View\View;

class PixelWrapRenderer
{
    protected $theme = "tailwind";
    public $paths = [];
    static $map = [
        'tab'       =>  Tab::class,
        'tabs'      =>  Tabs::class,
        'switch'    =>  Toggle::class,
        'text'      =>  Text::class,
        'progress'  =>  Progress::class,
        'navbar'    =>  Navbar::class,
        'sidebar'   =>  Sidebar::class,
        'textarea'  =>  TextArea::class,
        'image'     =>  Image::class,
        'badge'     =>  Badge::class,
        'heading'   =>  Heading::class,
        'button'    =>  Button::class,
        'column'    =>  Column::class,
        'listing'   =>  Listing::class,
        'modal'     =>  Modal::class,
        'row'       =>  Row::class,
        'grid'      =>  Grid::class,
        'card'      =>  Card::class,
        'hr'        =>  HorizontalRuler::class,
        'form'      =>  Form::class,
        'table'     =>  Table::class,
        'input'     =>  Input::class,
        'select'    =>  Select::class,
        'typeahead' =>  TypeAhead::class,
        'timeline'  =>  Timeline::class,
        null        =>  PlaceHolder::class,
        'exception' =>  \PixelWrap\Laravel\Facades\Components\Exception::class,
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
        $component = (object) $component;
        if(isset($component->type) || $component->type === null){
            $nodeName= mb_strtolower($component->type);
            if(isset(static::$map[$nodeName])) {
                return new (static::$map[$nodeName])($data, $component, $theme);
            }else{
                throw new NodeNotImplemented(sprintf("Node \"%s\" is not implemented.", mb_ucfirst($component->type)));
            }
        }else{
            $errors = ["Node type is not set"];
            $component = [(object) $component];
            $data = compact('errors', 'component');
            return new (static::$map["exception"])($data, $component, $theme);;
        }
    }

    /**
     * @throws Exception
     */
    function renderPage($page, $data = [], $options = []): View
    {
        $pageContainer = config('pixelwrap.page-root');
        if(view()->exists($pageContainer)) {
            $pageHtml = $this->render($page, $data, $options);
            return view('pixelwrap::page', compact('pageContainer','pageHtml', 'options'));
        }else{
            raise(null, sprintf("The page-root view \"%s\".blade.php does not exist. Please check your config file \"config/pixelwrap.php\" and try again.", $pageContainer));
        }
    }

    function renderComponent($component, $data = [], $options = []): string
    {
        return $this->renderComponents([$component], $data);
    }

    function render($page, $data = [], $options = []): string
    {
        $nodes = $this->loadPage($page);
        return $this->renderComponents($nodes, $data, $page);
    }

    private function renderComponents($nodes, $data, $page = null) :string
    {
        try {
            // Ensure $nodes is always an array of objects
            $nodes = array_map(fn($node) => is_array($node) ? (object) $node : $node, (array) $nodes);
            $components = array_map(fn($node) => static::from($data, $node, $this->theme), $nodes);
        } catch (ParseException $exception) {
            $errors = [$exception->getMessage()];
            $component = $this->loadFile($page);
            $components = [(object) ["type" => "Exception"]];
            $data = compact('errors', 'component');
        }

        return implode("", array_map(fn($component) => $component->render($data), $components));
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
        if(file_exists($file)) {
            return mb_trim(file_get_contents($file));
        } else {
            throw new Exception(sprintf('File "%s" not found. Searched in %s', $page, implode(", ", $this->paths)));
        }
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
