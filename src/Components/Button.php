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
    protected array $requiredFields = ["label"];

    public function parseProps($data): void
    {
        $size = mb_strtolower($this->node->size ?? 'small');
        $role = mb_strtolower($this->node->role ?? $this->role);
        $variant = mb_strtolower($this->node->variant ?? 'primary');
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
        $this->label = $this->node->label;
        $this->value = $this->node->value ?? "";
        $this->role  = $role;
        $this->addClass($rounded);
        $this->addClass($this->themeDefinitions["buttonVariants"][$variant]);
        $this->addClass($this->themeDefinitions["buttonSizes"][$size]);
    }
    public function render(...$args): View
    {
        if($this->role === "link") {
            $this->link = $this->buildLink($args);
        }
        return parent::render(...$args);
    }
}
