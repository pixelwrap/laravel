<?php

namespace PixelWrap\Laravel\Components;

class TextArea extends InputContract
{
    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $this->addClass($this->themeDefinitions["inputVariants"]["primary"]);
        $this->addClass($this->themeDefinitions["inputLabelVariants"]["primary"], "labelClasses");

        if ($input->disabled ?? false) {
            $this->addClass($this->themeDefinitions["inputVariants"]["disabled"]);
            $this->addClass($this->themeDefinitions["inputLabelVariants"]["disabled"], "labelClasses");
        }
    }
}
