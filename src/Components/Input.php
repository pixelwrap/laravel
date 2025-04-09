<?php

namespace PixelWrap\Laravel\Components;

class Input extends TextArea
{
    public string $fieldType = "text";
    public bool $autocomplete = false;
    public string|null $icon = null;

    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $fieldTypes = ["text", "email", "password", "number", "hidden", "date", "email", "readonly"];
        $fieldType = $node->fieldType ?? $this->fieldType;
        if (!in_array($fieldType, $fieldTypes)) {
            $this->errors[] = sprintf("\"%s\" only allows one of %s.", "TableField Type", implode(", ", $fieldTypes));
        }
        $this->autocomplete = $node->autocomplete ?? $this->autocomplete;
        $this->fieldType = $node->fieldType ?? $this->fieldType;
        $this->icon = $node->icon ?? $this->icon;
        if ($this->fieldType == "hidden") {
            $this->showLabel = false;
        }

        if ($this->icon) {
            $this->addClass('ps-10');
        }
    }
}
