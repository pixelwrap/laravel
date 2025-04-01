<?php

namespace PixelWrap\Laravel\Components;

use PixelWrap\Laravel\PixelWrapRenderer;

class Tabs extends CompoundComponent
{
    public $tabs = [];
    protected array $requiredFields = ["tabs"];

    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $this->id = $node->id ?? sprintf("tabs_%s", uniqid());
        if (isset($node->tabs)) {
            foreach ($node->tabs as $node) {
                $node->type = 'Tab';
                $this->tabs[] = PixelWrapRenderer::from($data, $node, $this->theme);
            }
        }
    }
}
