<?php

namespace PixelWrap\Laravel\Facades\Support;

class MenuItem
{
    public string $theme;
    public string $id;
    public string|null $label;
    public string|null $link;
    public string|null $icon;
    public int $level = 1;
    public array $items = [];
    public bool $expanded;
    public bool $selected;

    public function __construct(string $theme, string $label = null, string $link = null, string $icon = null, bool $selected = false, array $items = [], $level = 1, bool $expanded = false)
    {
        $this->theme    = $theme;
        $this->label    = $label;
        $this->link     = $link;
        $this->icon     = $icon;
        $this->level    = $level;
        $this->selected = $selected;
        $this->expanded = $expanded;
        $this->id = md5(sprintf("%s%s%s%s%s", $label, $link, $icon, json_encode($items), uniqid(rand(), true)));
        foreach ($items as $item) {
            $this->items[] = static::from($theme, $item, $level + 1);
        }
    }

    public function hasItems(): bool
    {
        return count($this->items) > 0;
    }

    public static function from(string $theme, $item, $level): self
    {
        $item = is_array($item) ? (object)$item : $item;
        return new static(
            $theme,
            $item->label ?? null,
            $item->link ?? null,
            $item->icon ?? null,
            $item->selected ?? false,
            $item->items ?? [],
            $level,
            $item->selected ?? false,
        );
    }
}
