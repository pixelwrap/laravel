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

    public function parseProps($card, $data): void
    {
        parent::parseProps($card, $data);
        $this->showLabel = $card->showLabel ?? $this->showLabel;
        $this->label = $card->label ?? $this->label;
    }
}
