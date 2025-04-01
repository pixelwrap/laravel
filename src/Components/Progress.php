<?php

namespace PixelWrap\Laravel\Facades\Components;

class Progress extends ComponentContract
{
    public int $value = 0;
    public bool $showLabel = true;

    public function parseProps($node, $data): void
    {
        $this->showLabel = $node->showLabel ?? $this->showLabel;
        $value = $node->value ?? 0;
        $this->value = intval(interpolateString($value, $data));
    }
}
