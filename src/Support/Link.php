<?php

namespace PixelWrap\Laravel\Support;

class Link
{
    public string $label;
    public string $url;
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
