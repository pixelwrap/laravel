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
    public string $id = "";
    public mixed $node;
    public bool $ignoreNodes = true;
    public function __construct($data, $node, $theme = "tailwind")
    {
        $this->node = $node;
        $this->template = mb_strtolower(class_basename(static::class));
        $this->name = $this->template;
        $this->id = $node->id ??  $this->id;
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

    protected abstract function parseProps($node, $data): void;


    protected function parseBoxModelProperties($node): void
    {
        $spacing = [
            "border"  => "borderOptions",
            "margin"  => "marginOptions",
            "padding" => "paddingOptions",
            "span"    => "colSpanOptions",
            "gap"     => "gapOptions"
        ];
        foreach ($spacing as $key => $values){
            $this->validateAndParseBoxModel($node, $key, $values);
        }
    }
    protected function validateAndParseBoxModel($node, $key, $map): void
    {
        $options  =  $this->themeDefinitions[$map];
        $value    = $node->{$key} ?? 'default';
        if(is_array($value)){
            $value = implode(' ', $value);
        }
        $inputs =  mb_split(" ", mb_strtolower($value));
        $keys   = array_keys($options);
        foreach ($inputs as $input){
            if(!in_array($input, $keys)) {
                $this->errors[] = sprintf("\"%s\" only allows one of %s.", mb_ucfirst($key) , implode(", ", $keys));
            }else{
                if($key === "span"){
                    $this->addClass($options[$input],"spanClasses");
                }else {
                    $this->addClass($options[$input]);
                }
            }
        }
    }

    protected function addClass(string $class, $field = "classes"): static
    {
        $this->{$field} = mb_trim(sprintf("%s %s", $this->{$field} ?? '', $class));
        return $this;
    }

    public function render(...$args): View
    {
        if(count($this->errors) > 0){
            return view("pixelwrap::components/{$this->theme}/exception", ["errors" => $this->errors, "component" => $this]);
        }else{
            $name = $this->template;
            return view(sprintf("pixelwrap::components/%s/%s", $this->theme, $this->template),[...$args, $name => $this]);
        }
    }

    protected function validateModel($node): void
    {
        $message = "%s must be set. Please check if your template is compliant with the specification.";
        foreach ($this->requiredFields as $field){
            if(!isset($node->{$field})){
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
