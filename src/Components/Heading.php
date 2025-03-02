<?php

namespace PixelWrap\Laravel\Components;

class Heading extends Text
{
    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $size = mb_strtolower($this->node->size ?? 'small');
        $keys = array_keys($this->themeDefinitions["headingTypes"]);
        if (!in_array($size, $keys)) {
            $this->errors[] = sprintf("Heading \"size\" must be one of %s. ", implode(", ", $keys));
        } else {
            $this->addClass($this->themeDefinitions["headingTypes"][$size]);
        }
    }
}
