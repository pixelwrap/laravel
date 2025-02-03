<?php

namespace PixelWrap\Laravel\Components;

use PixelWrap\Laravel\PixelWrapRenderer;
use PixelWrap\Laravel\Support\NodeNotImplemented;

class CompoundComponent extends ComponentContract
{
    protected array $requiredFields = ["nodes"];
    public array $nodes = [];

    /**
     * @throws NodeNotImplemented
     */
    public function parseProps($data): void
    {
        $this->nodes = [];
        foreach ($this->node->nodes as $node) {
            $this->nodes[] = PixelWrapRenderer::from($data, $node, $this->theme);
        }
    }
}
