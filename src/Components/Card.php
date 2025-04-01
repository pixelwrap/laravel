<?php

namespace PixelWrap\Laravel\Facades\Components;

use Illuminate\Pagination\Paginator;
use PixelWrap\Laravel\Facades\PixelWrapRenderer;
use PixelWrap\Laravel\Facades\Support\Dataset;
use PixelWrap\Laravel\Facades\Traits\HasText;

class Card extends CompoundComponent
{
    use HasText;

    public bool $showTitle = true;
    public string $label = "Title not set";

    public function parseProps($card, $data): void
    {
        parent::parseProps($card, $data);
        $this->showTitle = $card->showTitle ?? $this->showTitle;
        $this->label = $card->label ?? $this->label;
    }
}
