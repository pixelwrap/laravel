<?php

namespace PixelWrap\Laravel\Support;

use PixelWrap\Laravel\Traits\HasText;

class Link
{
    use HasText;

    public string $label;
    public string $url;
    protected array $data;
    public string|null $icon = null;

    public function __construct(string $label, string $url, string|null $icon = null)
    {
        $this->label = $label;
        $this->url = $url;
        $this->icon = $icon;
    }



    public static function from(string $label, string $url, string|null $icon): self
    {

        return new static($label, $url, $icon);
    }
}
