<?php

namespace PixelWrap\Laravel\Components;

use PixelWrap\Laravel\Support\MenuItem;
use PixelWrap\Laravel\Traits\HasText;

class Sidebar extends ComponentContract
{
    use HasText;

    public string $id = "sidebar";
    public MenuItem $menu;
    protected array $requiredFields = ["items", "id"];
    public bool $showDrawer = true;
    public bool $expanded = true;

    public function parseProps($node, $data): void
    {
        $this->showDrawer = $node->showDrawer ?? $this->showDrawer;
        if (isset($node->items)) {
            $this->menu = new MenuItem($this->theme, null, null, null, false, $node->items, 0, true);
        }
    }

}
