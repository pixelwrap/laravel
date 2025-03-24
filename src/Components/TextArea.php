<?php

namespace PixelWrap\Laravel\Components;

class TextArea extends InputContract
{
    public $rows = 3;

    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $this->rows = $node->rows ?? $this->rows;
        $this->addClass($this->themeDefinitions["inputVariants"]["primary"]);
        $this->addClass($this->themeDefinitions["inputLabelVariants"]["primary"], "labelClasses");

        if ($input->disabled ?? false) {
            $this->addClass($this->themeDefinitions["inputVariants"]["disabled"]);
            $this->addClass($this->themeDefinitions["inputLabelVariants"]["disabled"], "labelClasses");
        }
    }

    public function value($args = [])
    {
        $value = interpolateString($this->value, $args);
        return filter($this->filters, $value);
    }
}
