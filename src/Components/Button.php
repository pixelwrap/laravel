<?php

namespace PixelWrap\Laravel\Components;

class Button extends ComponentContract
{
    public string $label = "Label not set";
    public string $role = "submit";
    public string $value = "";
    protected array $requiredFields = ["label"];

    public function parseProps($data): void
    {
        $size = mb_strtolower($this->node->size ?? 'small');
        $role = mb_strtolower($this->node->role ?? 'button');
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

        if($role==="link"){
            [$errors, $link] = buildLink($this, get_defined_vars());
        }
    }
}
