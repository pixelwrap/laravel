<?php

namespace PixelWrap\Laravel\Components;

class Image extends ComponentContract
{
    public string $url = "";
    public string $alt = "";
    protected array $requiredFields = ["url"];

    public function parseProps($node, $data): void
    {
        $this->url = $node->url ?? $this->label;
        $this->alt = $node->alt ?? $this->alt;
    }

}
