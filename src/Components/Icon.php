<?php

namespace PixelWrap\Laravel\Components;

use Illuminate\Contracts\View\View;

class Icon extends ComponentContract
{
    public string $name = "";
    protected array $requiredFields = ["name"];

    public function parseProps($node, $data): void
    {
        $this->name = $node->name ?? $this->name;
    }

    public function icon($args = []): string
    {
        return interpolateString($this->name, [...$this->data,...$args]);
    }
}
