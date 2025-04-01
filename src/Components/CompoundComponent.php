<?php

namespace PixelWrap\Laravel\Facades\Components;

use PixelWrap\Laravel\Facades\PixelWrapRenderer;
use PixelWrap\Laravel\Facades\Support\NodeNotImplemented;

class CompoundComponent extends ComponentContract
{
    protected array $requiredFields = ["nodes"];
    public array $nodes = [];

    /**
     * @throws NodeNotImplemented
     */
    public function parseProps($node, $data): void
    {
        if (isset($node->nodes)) {
            foreach ($node->nodes as $node) {
                $this->nodes[] = PixelWrapRenderer::from($data, $node, $this->theme);
            }
        }
    }
}
