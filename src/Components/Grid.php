<?php

namespace PixelWrap\Laravel\Components;

class Grid extends CompoundComponent
{
    public function parseProps($data): void
    {
        parent::parseProps($data);
        $columns = $this->node->cols ?? 12;
        $this->addClass($this->themeDefinitions["columnOptions"][$columns]);
        $options = range(1, 12);
        foreach ($this->nodes as $index => $node) {
            $span = $node->span ?? 3;
            if (!in_array($span, $options)) {
                $this->errors[] = sprintf("Grid span for node \"%s\" only allows one of %s.", $index + 1, implode(", ", $options));
                $ignoreNodes = false;
            }
        }
    }
}
