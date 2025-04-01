<?php

namespace PixelWrap\Laravel\Facades\Components;

use PixelWrap\Laravel\Facades\Traits\HasText;

class Text extends ComponentContract
{
    use HasText;

    public string $label = "Label not set";
    protected array $requiredFields = ["label"];

    public function parseProps($node, $data): void
    {
        $this->label = $node->label ?? $this->label;
    }

}
