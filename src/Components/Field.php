<?php

namespace PixelWrap\Laravel\Components;

use PixelWrap\Laravel\Traits\HasText;

class Field extends Text
{
    use HasText;

    public string $value = "";
    public string $default = "";

    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $this->default = $node->default ?? $this->default;
        $this->value   = $this->node->value ?? $this->default;
    }

    public function value($args = [])
    {
        $value =  interpolateString($this->value, [...$args, ...$this->data]);
        return filter($this->filters, $value);
    }
}
