<?php

namespace PixelWrap\Laravel\Components;

use Illuminate\Contracts\View\View;
use PixelWrap\Laravel\Traits\HasLink;

class Button extends ComponentContract
{
    use HasLink;

    public string $label = "Label not set";
    public string $role = "submit";
    public string $value = "";
    public string $link = "";
    public mixed  $action;
    protected array $requiredFields = ["label"];

    public function parseProps($node, $data): void
    {
        $size = mb_strtolower($node->size ?? 'small');
        $role = mb_strtolower($node->role ?? $this->role);
        $variant = mb_strtolower($node->variant ?? 'primary');
        $rounded =  "rounded-sm";
        $validations= [
            "role"    => ["link","reset","button","submit"],
            "size"    => array_keys($this->themeDefinitions["buttonSizes"]),
            "variant" => array_keys($this->themeDefinitions["buttonVariants"])
        ];
        foreach ($validations as $key => $options){
            if(!in_array($$key, $options)){
                $this->errors[] = sprintf("\"%s\" only allows one of %s.", mb_ucfirst($key) , implode(", ", $options));
            }
        }
        $this->label   = $node->label;
        $this->value   = $node->value ?? "";
        $this->role    = $role;
        $this->addClass($rounded);
        $this->addClass($this->themeDefinitions["buttonVariants"][$variant]);
        $this->addClass($this->themeDefinitions["buttonSizes"][$size]);

        if($this->role === "link") {
            $field = "action";
            if(isset($node->{$field})) {
                $this->action = $node->action;
            } else {
                $message = "Action must be set. Please check if your template is compliant with the specification.";
                $this->errors[] = $message;
            }
        }
    }

    public function render(...$args): View
    {
        if($this->role === "link") {
            $this->link = $this->buildLink($this->action, $args);
        }
        return parent::render(...$args);
    }
}
