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
        if (isset($node->nodes)) {
            foreach ($node->nodes as $node) {
                $this->nodes[] = PixelWrapRenderer::from($data, $node, $this->theme);
            }
        }
        $utilityClasses = ['flexGrowOptions', 'alignmentOptions', 'justifyOptions'];
        foreach ($utilityClasses as $name => $class) {
            $options = $this->themeDefinitions[$class];
            $input = mb_strtolower($name);
            $keys = array_keys($options);
            if (!in_array($input, $keys)) {
                $this->errors[] = sprintf("\"%s\" only allows one of %s. Found '%s'.", mb_ucfirst($name), implode(", ", $keys), $input);
            } else {
                $this->addClass($options[$name]);
            }
        }
    }
}
