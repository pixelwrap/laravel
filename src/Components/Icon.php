<?php

namespace PixelWrap\Laravel\Components;

class Icon extends ComponentContract
{
    public string $name = "";
    protected array $requiredFields = ["name"];

    public function parseProps($node, $data): void
    {
        $this->name = $node->name ?? $this->name;
    }

}
