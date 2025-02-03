<?php

namespace PixelWrap\Laravel\Components;

use Illuminate\Contracts\View\View;
use PixelWrap\Laravel\Support\InvalidValue;

abstract class ComponentContract
{
    protected array $supportedThemes = ["tailwind"];
    protected array $themeDefinitions = [];
    protected array $requiredFields = [];
    public array $errors = [];

    public string $template;
    public string $name;
    public string $theme;
    public string $classes = "";
    public mixed $node;
    public bool $ignoreNodes = true;
    public function __construct($data, $node, $theme = "tailwind")
    {
        $this->template = mb_strtolower(class_basename(static::class));
        $this->name = $this->template;
        if (in_array($theme, $this->supportedThemes)) {
            $this->theme = $theme;
            $this->node  = $node;
            $this->setThemeDefinitions();
            $this->validateModel();
            $this->parseBoxModelProperties();
            $this->parseProps($data);
        } else {
            throw new InvalidValue("Theme '{$theme}' is not supported");
        }
    }

    protected abstract function parseProps($data): void;


    protected function parseBoxModelProperties(): void
    {
        $spacing = [
            "border"  => "borderOptions",
            "margin"  => "marginOptions",
            "padding" => "paddingOptions",
            "gap"     => "gapOptions"
        ];
        foreach ($spacing as $key => $values){
            $this->validateAndParseBoxModel($key, $values);
        }
    }
    protected function validateAndParseBoxModel($key, $map): void
    {
        $options  =  $this->themeDefinitions[$map];
        $value    = $this->node->{$key} ?? 'default';
        if(is_array($value)){
            $value = implode(' ', $value);
        }
        $inputs =  mb_split(" ", mb_strtolower($value));
        foreach ($inputs as $input){
            if(!in_array($input, array_keys($options))) {
                $this->errors[] = sprintf("\"%s\" only allows one of %s.", mb_ucfirst($key) , implode(", ", $options));
            }else{
                $this->addClass($options[$input]);
            }
        }
    }

    protected function addClass(string $class): static
    {
        if($class) {
            $this->classes = sprintf("%s %s", $this->classes, $class);
        }
        return $this;
    }

    public function render(): View
    {
        if(count($this->errors) > 0){
            return view("pixelwrap::components/{$this->theme}/exception", ["errors" => $this->errors, "component" => $this]);
        }else{
            $name = $this->template;
            return view(sprintf("pixelwrap::components/%s/%s", $this->theme, $this->template),[$name => $this]);
        }
    }

    protected function validateModel(): void
    {
        $message = "%s must be set. Please check if your template is compliant with the specification.";
        foreach ($this->requiredFields as $field){
            if(!isset($this->node->{$field})){
                $this->errors[] = sprintf($message, mb_ucfirst($field));
            }
        }
    }

    protected function setThemeDefinitions(): void
    {
        $vars = get_defined_vars();
        (require pixelwrap_resource("components/{$this->theme}/definitions.php"));
        $this->themeDefinitions = array_diff_key(get_defined_vars(), [...$vars, "vars" => $vars]);
    }
}
