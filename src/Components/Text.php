<?php

namespace PixelWrap\Laravel\Components;

class Text extends ComponentContract
{
    public string $label = "Label not set";
    protected array $requiredFields = ["label"];

    public function parseProps($node, $data): void
    {
        $this->label = $node->label ?? $this->label;
    }

    public function text()
    {
        return $this->label;
    }
}
