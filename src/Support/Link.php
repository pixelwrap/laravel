<?php

namespace PixelWrap\Laravel\Support;

use PixelWrap\Laravel\Traits\HasLink;
use PixelWrap\Laravel\Traits\HasText;

class Link
{
    use HasText, HasLink;

    public string $label;
    public mixed $link;
    public array $params;
    protected array $data;
    protected array $filters = [];
    public string|null $icon = null;

    public function __construct(string $label, mixed $link, string|null $icon = null)
    {
        $this->label = $label;
        $this->link = $link;
        $this->icon = $icon;
    }

    public function link($args)
    {
        if (is_string($this->link)) {
            return $this->buildLink($this->link, $args);
        } else {
            $link = $this->link;
            $link->route = $link->name;
            return $this->buildLink($link, $args);
        }
    }

    public static function from($link): self
    {
        return new static($link->label ?? 'Not Set', $link->url ?? $link->route, $link->icon ?? null);
    }
}
