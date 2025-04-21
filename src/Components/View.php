<?php

namespace PixelWrap\Laravel\Components;

use PixelWrap\Laravel\Traits\HasText;

class View extends ComponentContract
{
    use HasText;

    protected array $requiredFields = ["name"];
    public string $name = "";

    public function parseProps($node, $data): void
    {
        $this->name = $node->name ?? $this->name;
    }
}
