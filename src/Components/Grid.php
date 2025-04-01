<?php

namespace PixelWrap\Laravel\Facades\Components;

class Grid extends CompoundComponent
{
    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $columns = $this->node->cols ?? "full";
        foreach (explode_prop($columns) as $column) {
            $options = $this->themeDefinitions["colSpanOptions"];
            if (!in_array($column, array_keys($options))) {
                $this->errors[] = sprintf("Grid column \"%s\" only allows one of %s.", implode(", ", array_values($options)));
                $this->ignoreNodes = false;
            } else {
                $this->addClass($this->themeDefinitions["columnOptions"][$columns]);
            }
        }
        $options = array_keys($this->themeDefinitions["colSpanOptions"]);
        foreach ($node->nodes as $index => $node) {
            $spans = $node->span ?? 3;
            foreach (explode_prop($spans) as $span) {
                if (!in_array($span, $options)) {
                    $this->errors[] = sprintf("Grid span for node \"%s\" only allows one of %s. Found %s", $index + 1, implode(", ", $options),$span);
                    $this->ignoreNodes = false;
                }
            }
        }
    }
}
