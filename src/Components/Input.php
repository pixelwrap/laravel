<?php

namespace PixelWrap\Laravel\Components;

class Input extends ComponentContract
{
    public string $id;
    public string $label = "Label not set";
    public string $fieldType = "text";
    public string $value = "";
    public bool $showLabel = true;
    public bool $required = true;
    public bool $autocomplete = true;
    protected array $requiredFields = ["label","id"];

    public function parseProps($data): void
    {
        $fieldTypes = ["text", "email", "password", "number","hidden"];
        $fieldType = $this->node->fieldType ?? $this->fieldType;
        if (!in_array($fieldType, $fieldTypes)) {
            $this->errors[] = sprintf("\"%s\" only allows one of %s.","Field Type", implode(", ", $fieldTypes));
        }else {
            $inputId = $this->node->id;
            $value = old($inputId, $data[$inputId] ?? $input->value ?? "");
            $this->value = is_string($value) ? $value : json_encode($value);
        }
        $this->id = $this->node->id;
        $this->fieldType = $fieldType;
        $this->showLabel = $this->node->showLabel ?? $this->showLabel;
        $this->label = $this->node->label ?? $this->label;
        $this->autocomplete = $this->node->autocomplete ?? $this->autocomplete;
    }
}
