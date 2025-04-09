<?php

namespace PixelWrap\Laravel\Components;

use Illuminate\Contracts\View\View;
use PixelWrap\Laravel\Support\InvalidValue;

abstract class ComponentContract
{
    protected array $supportedThemes = ["tailwind"];
    protected array $themeDefinitions = [];
    protected array $requiredFields = [];
    protected mixed $showIf = [];
    protected mixed $hideIf = [];
    public array $errors = [];
    public array $filters = [];
    public string $template;
    public string $name;
    public string $theme;
    public string $classes = "";
    public string $id = "";
    public mixed $node;
    public mixed $data;
    public $span = "full";
    public bool $ignoreNodes = true;
    public $rounded = "none";
    public bool $rounding = true;

    public function __construct($data, $node, $theme = "tailwind", $rounded = "none")
    {
        $this->node = $node;
        $this->data = $data;
        $this->template = mb_strtolower(class_basename(static::class));
        $this->name = $this->template;
        $this->id = $node->id ?? $this->id;
        $this->rounded = $node->rounded ?? $rounded;
        $this->showIf = $node->{"show-if"} ?? $this->showIf;
        $this->hideIf = $node->{"hide-if"} ?? $this->hideIf;
        $this->filters = explode("|", $node->filters ?? null);
        if (in_array($theme, $this->supportedThemes)) {
            $this->theme = $theme;
            $this->setThemeDefinitions();
            $this->validateModel($node);
            $this->parseBoxModelProperties($node);
            $this->parseProps($node, $data);
        } else {
            throw new InvalidValue("Theme '{$theme}' is not supported");
        }
    }

    abstract protected function parseProps($node, $data): void;

    protected function parseBoxModelProperties($node): void
    {
        $spacing = [
            "border" => "borderOptions",
            "margin" => "marginOptions",
            "padding" => "paddingOptions",
            "span" => "colSpanOptions",
            "gap" => "gapOptions",
            "rounded" => "borderRadiusOptions",
        ];
        foreach ($spacing as $key => $values) {
            $this->validateAndParseBoxModel($node, $key, $values);
        }
    }

    protected function validateAndParseBoxModel($node, $key, $map): void
    {
        $options = $this->themeDefinitions[$map];
        $value = $node->{$key} ?? ($this->{$key} ?? "default");
        if (is_array($value)) {
            $value = implode(" ", $value);
        }
        $inputs = mb_split(" ", mb_strtolower($value));
        $keys = array_keys($options);
        foreach ($inputs as $input) {
            if (!in_array($input, $keys)) {
                $this->errors[] = sprintf("\"%s\" only allows one of %s. Found '%s'.", mb_ucfirst($key), implode(", ", $keys), $input);
            } else {
                if ($key === "span") {
                    $this->addClass($options[$input], "spanClasses");
                } else if ($key === "rounded") {
                    if ($this->rounding) {
                        $this->addClass($options[$input]);
                    }
                } else {
                    $this->addClass($options[$input]);
                }
            }
        }
    }

    protected function addClass(string $class, $field = "classes"): static
    {
        $this->{$field} = mb_trim(sprintf("%s %s", $this->{$field} ?? "", $class));
        return $this;
    }

    public function render($args = []): View|null
    {
        if (count($this->errors) > 0) {
            return view("pixelwrap::components/{$this->theme}/exception", [
                "errors" => $this->errors,
                "component" => $this,
            ]);
        } else {
            $showIf = $this->showIf ?? false;
            $hideIf = $this->hideIf ?? false;
            $show = $showIf ? false : true;
            if ($showIf || $hideIf) {
                $conditions = $showIf ? $showIf : $hideIf;
                $context = [...$args, ...$this->data];
                foreach ($conditions as $key => $condition) {
                    if (is_scalar($condition) || is_null($condition)) {
                        $condition = [$key => $condition];
                    }
                    foreach ($condition as $key => $value) {
                        if ((isset($context[$key]) && $context[$key] === $value) || (!isset($context[$key]) && $value === null)) {
                            $show = $showIf ? true : false;
                            break 2;
                        }
                    }
                }
            }
            if ($show) {
                $name = $this->template;
                return view(sprintf("pixelwrap::components/%s/%s", $this->theme, $this->template), [...$args, $name => $this]);
            } else {
                return null;
            }
        }
    }

    protected function validateModel($node): void
    {
        $message = "%s must be set. Please check if your template is compliant with the specification.";
        foreach ($this->requiredFields as $field) {
            if (!isset($node->{$field})) {
                $this->errors[] = sprintf($message, mb_ucfirst($field));
            }
        }
    }

    protected function setThemeDefinitions(): void
    {
        $vars = get_defined_vars();
        require pixelwrap_resource("components/{$this->theme}/definitions.php");
        $this->themeDefinitions = array_diff_key(get_defined_vars(), [...$vars, "vars" => $vars]);
    }

    public function id($args)
    {
        return interpolateString($this->id, [...($this->data ?? []), ...$args]);
    }
}
