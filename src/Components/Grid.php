<?php

namespace PixelWrap\Laravel\Components;

class Grid extends CompoundComponent
{
    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $columns = $this->node->cols ?? 12;
        $this->addClass($this->themeDefinitions["columnOptions"][$columns]);
        $options = range(1, 12);
        foreach ($node->nodes as $index => $node) {
            $span = $node->span ?? 3;
            if (!in_array($span, $options)) {
                $this->errors[] = sprintf("Grid span for node \"%s\" only allows one of %s.", $index + 1, implode(", ", $options));
                $this->ignoreNodes = false;
            }
        }
    }
}
