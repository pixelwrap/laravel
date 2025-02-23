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
    public function parseProps($node, $data): void
    {
        $this->nodes = [];
        foreach ($node->nodes as $node) {
            $inflatedNode  = PixelWrapRenderer::from($data, $node, $this->theme);
            $this->nodes[] =  $inflatedNode;
        }
    }
}
