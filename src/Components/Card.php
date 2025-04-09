<?php

namespace PixelWrap\Laravel\Components;

use Illuminate\Pagination\Paginator;
use PixelWrap\Laravel\PixelWrapRenderer;
use PixelWrap\Laravel\Support\Dataset;
use PixelWrap\Laravel\Traits\HasText;

class Card extends CompoundComponent
{
    use HasText;

    public bool $showLabel = true;
    public string $label = "Title not set";
    public bool $rounding = true;

    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $this->showLabel = $node->showLabel ?? $this->showLabel;
        $this->label = $node->label ?? $this->label;
    }
}
