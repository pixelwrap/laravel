<?php

namespace PixelWrap\Laravel\Facades\Components;


use PixelWrap\Laravel\Facades\Traits\HasText;

class Tab extends CompoundComponent
{
    use HasText;

    public string|null $icon = null;
    public string $label = "Label Not Set";
    protected array $requiredFields = ["label"];

    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $this->icon = $node->icon ?? $this->icon;
        $this->label = $node->label ?? $this->label;
        $this->id = $node->id ?? sprintf("tab_%s", uniqid());
    }
}
