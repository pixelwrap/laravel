<?php

namespace PixelWrap\Laravel\Components;

class Heading extends ComponentContract
{
    public string $label = "Heading label not set";
    protected array $requiredFields = ["label"];

    public function parseProps($data): void
    {
        $size = mb_strtolower($this->node->size ?? 'small');
        $keys = array_keys($this->themeDefinitions["headingTypes"]);
        if (!in_array($size, $keys)) {
            $this->errors[] = sprintf("Heading \"size\" must be one of %s. ", implode(", ", $keys));
        } else {
            $this->label = $this->node->label;
            $this->addClass($this->themeDefinitions["headingTypes"][$size]);
        }
    }
}
