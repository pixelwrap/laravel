<?php

namespace PixelWrap\Laravel;

use Exception;
use PixelWrap\Laravel\Components\Badge;
use PixelWrap\Laravel\Components\Button;
use PixelWrap\Laravel\Components\Column;
use PixelWrap\Laravel\Components\ComponentContract;
use PixelWrap\Laravel\Components\Field;
use PixelWrap\Laravel\Components\Form;
use PixelWrap\Laravel\Components\Image;
use PixelWrap\Laravel\Components\Navbar;
use PixelWrap\Laravel\Components\Sidebar;
use PixelWrap\Laravel\Components\Progress;
use PixelWrap\Laravel\Components\Tab;
use PixelWrap\Laravel\Components\Tabs;
use PixelWrap\Laravel\Components\TextArea;
use PixelWrap\Laravel\Components\Grid;
use PixelWrap\Laravel\Components\Card;
use PixelWrap\Laravel\Components\Listing;
use PixelWrap\Laravel\Components\Text;
use PixelWrap\Laravel\Components\Heading;
use PixelWrap\Laravel\Components\HorizontalRuler;
use PixelWrap\Laravel\Components\Input;
use PixelWrap\Laravel\Components\PlaceHolder;
use PixelWrap\Laravel\Components\Row;
use PixelWrap\Laravel\Components\Select;
use PixelWrap\Laravel\Components\Table;
use PixelWrap\Laravel\Components\Timeline;
use PixelWrap\Laravel\Components\Toggle;
use PixelWrap\Laravel\Components\TypeAhead;
use PixelWrap\Laravel\Components\Modal;
use PixelWrap\Laravel\Support\NodeNotImplemented;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Contracts\View\View;

class PixelWrapRenderer
{
    protected $theme = "tailwind";
    protected $rounded = "none";
    public $paths = [];
    static $map = [
        'view' => Components\View::class,
        'tab' => Tab::class,
        'tabs' => Tabs::class,
        'switch' => Toggle::class,
        'text' => Text::class,
        'icon' => Icon::class,
        'progress' => Progress::class,
        'navbar' => Navbar::class,
        'sidebar' => Sidebar::class,
        'textarea' => TextArea::class,
        'image' => Image::class,
        'badge' => Badge::class,
        'heading' => Heading::class,
        'button' => Button::class,
        'column' => Column::class,
        'listing' => Listing::class,
        'modal' => Modal::class,
        'row' => Row::class,
        'grid' => Grid::class,
        'card' => Card::class,
        'hr' => HorizontalRuler::class,
        'form' => Form::class,
        'table' => Table::class,
        'input' => Input::class,
        'field' => Field::class,
        'select' => Select::class,
        'typeahead' => TypeAhead::class,
        'timeline' => Timeline::class,
        null => PlaceHolder::class,
        'exception' => Components\Exception::class,
        'horizontalruler' => HorizontalRuler::class,
    ];

    static function make($theme = "tailwind", $paths = []): static
    {
        return (new static)->setTheme($theme)->setPaths($paths);
    }

    /**
     * @throws NodeNotImplemented
     */
    static function from($data, $component, $theme, $rounded = "none"): ComponentContract
    {
        $component = (object)$component;
        if (isset($component->type) || $component->type === null) {
            $nodeName = mb_strtolower($component->type);
            if (isset(static::$map[$nodeName])) {
                return new (static::$map[$nodeName])($data, $component, $theme, $rounded);
            } else {
                throw new NodeNotImplemented(sprintf("Node \"%s\" is not implemented.", mb_ucfirst($component->type)));
            }
        } else {
            $errors = ["Node type is not set"];
            $component = [(object)$component];
            $data = compact('errors', 'component');
            return new (static::$map["exception"])($data, $component, $theme, $rounded);
        }
    }

    /**
     * @throws Exception
     */
    function renderPage($page, $data = []): View
    {
        $pageContainer = config('pixelwrap.page-root');
        $rounded = config('pixelwrap.rounded');
        if (view()->exists($pageContainer)) {
            $pageHtml = $this->render($page, $data, $rounded);
            return view('pixelwrap::page', compact('pageContainer', 'pageHtml'));
        } else {
            raise(null, sprintf("The page-root view \"%s\".blade.php does not exist. Please check your config file \"config/pixelwrap.php\" and try again.", $pageContainer));
        }
    }

    function renderComponent($component, $data = []): string
    {
        return $this->renderComponents([$component], $data);
    }

    function render($page, $data = [], $rounded = "none"): string
    {
        $nodes = $this->loadPage($page);
        return $this->renderComponents($nodes, $data, $rounded, $page);
    }

    private function renderComponents($nodes, $data, $rounded = "none", $page = null): string
    {
        try {
            // Ensure $nodes is always an array of objects
            $nodes = array_map(fn($node) => is_array($node) ? (object)$node : $node, (array)$nodes);
            $components = array_map(fn($node) => static::from($data, $node, $this->theme, $rounded), $nodes);
        } catch (ParseException $exception) {
            $errors = [$exception->getMessage()];
            $component = $this->loadFile($page);
            $components = [(object)["type" => "Exception"]];
            $data = compact('errors', 'component');
        }

        return implode("", array_map(fn($component) => $component->render($data), $components));
    }

    function loadPage($page)
    {
        $nodes = Yaml::parse($this->loadFile($page), Yaml::PARSE_OBJECT_FOR_MAP);
        if (is_object($nodes)) {
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
                $file = sprintf("%s/%s.yaml", $path, $page);
                if (file_exists($file)) {
                    break;
                }
            }
        }
        if (file_exists($file)) {
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

    public function setRounded(string $rounded): static
    {
        $this->rounded = $rounded;
        return $this;
    }

    public function setPaths(array $paths): static
    {
        $this->paths = $paths;
        return $this;
    }
}
