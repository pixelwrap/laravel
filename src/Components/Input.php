<?php

namespace PixelWrap\Laravel\Components;

class Input extends ComponentContract
{
    public string $label = "Label not set";
    public string $role = "submit";
    public string $value = "";
    public bool $showLabel = true;
    protected array $requiredFields = ["label"];

    public function parseProps($data): void
    {
        $fieldType = $this->node->fieldType ?? "text";
        $value = $this->node->value ?? "";
        $filedTypes = ["text", "email", "password", "number"];
        if (!in_array($fieldType, $filedTypes)) {
            $this->errors[] = sprintf("\"%s\" only allows one of %s.","Field Type", implode(", ", $filedTypes));
        }
        $this->value = is_string($value) ? $value : json_encode($value);
    }
}
