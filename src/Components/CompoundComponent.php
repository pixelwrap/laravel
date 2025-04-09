<?php

namespace PixelWrap\Laravel\Components;

use PixelWrap\Laravel\PixelWrapRenderer;
use PixelWrap\Laravel\Support\NodeNotImplemented;

class CompoundComponent extends ComponentContract
{
    protected array $requiredFields = ["nodes"];
    public array $nodes = [];

    // Layout Support
    public string $grow = "";
    public string $justify = "";
    public string $align = "start";

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

        // Handle flex-related properties
        $this->grow = $node->grow ?? $this->grow;
        $this->justify = $node->justify ?? $this->justify;
        $this->align = $node->align ?? $this->align;

        $this->addClass($this->getFlexClasses());
    }

    /**
     * Optionally expose utility classes for Tailwind or custom renderer
     */
    public function getFlexClasses(): string
    {
        $classes = [];

        if ($this->grow) {
            $classes[] = "flex-grow-{$this->grow}";
        }

        if ($this->justify) {
            $classes[] = "justify-{$this->justify}";
        }

        if ($this->align) {
            $classes[] = "items-{$this->align}";
        }

        return implode(' ', $classes);
    }
}
