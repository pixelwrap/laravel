<?php

namespace PixelWrap\Laravel\Components;

class Input extends TextArea
{
    public string $fieldType = "text";
    public bool $autocomplete = false;

    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $fieldTypes = ["text", "email", "password", "number", "hidden", "date", "email"];
        $fieldType = $node->fieldType ?? $this->fieldType;
        if (!in_array($fieldType, $fieldTypes)) {
            $this->errors[] = sprintf("\"%s\" only allows one of %s.", "Field Type", implode(", ", $fieldTypes));
        }
        $this->autocomplete = $node->autocomplete ?? $this->autocomplete;
        $this->fieldType    = $node->fieldType ?? $this->fieldType;
        if ($this->fieldType == "hidden") {
            $this->showLabel = false;
        }
    }
}
