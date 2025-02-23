<?php

namespace PixelWrap\Laravel\Components;

class Input extends InputContract
{
    public string $fieldType = "text";
    public bool $autocomplete = false;

    public function parseProps($node, $data): void
    {
        $fieldTypes = ["text", "email", "password", "number", "hidden"];
        $fieldType = $this->node->fieldType ?? $this->fieldType;
        if (!in_array($fieldType, $fieldTypes)) {
            $this->errors[] = sprintf("\"%s\" only allows one of %s.", "Field Type", implode(", ", $fieldTypes));
        }
        $this->autocomplete = $this->node->autocomplete ?? $this->autocomplete;

        $this->addClass($this->themeDefinitions["inputVariants"]["primary"]);
        $this->addClass($this->themeDefinitions["inputLabelVariants"]["primary"],"labelClasses");

        if ($input->disabled ?? false) {
            $this->addClass($this->themeDefinitions["inputVariants"]["disabled"]);
            $this->addClass($this->themeDefinitions["inputLabelVariants"]["disabled"],"labelClasses");
        }
        parent::parseProps($node, $data);
    }
}
