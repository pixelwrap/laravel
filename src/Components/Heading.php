<?php

namespace PixelWrap\Laravel\Facades\Components;
use PixelWrap\Laravel\Facades\Traits\HasAction;

class Heading extends Text
{
    use HasAction;
    public array $actions = [];

    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $actions = $node->actions ?? [];
        $size = mb_strtolower($this->node->size ?? 'small');
        $keys = array_keys($this->themeDefinitions["headingTypes"]);
        if (!in_array($size, $keys)) {
            $this->errors[] = sprintf("Heading \"size\" must be one of %s. ", implode(", ", $keys));
        } else {
            $this->addClass($this->themeDefinitions["headingTypes"][$size]);
        }
        $this->buildActions($actions);
    }
}
