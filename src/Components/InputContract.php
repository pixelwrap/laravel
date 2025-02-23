<?php

namespace PixelWrap\Laravel\Components;

class InputContract extends ComponentContract
{
    public string $id;
    public string $label = "Label not set";
    public string $placeholder = "";
    public string $value = "";
    public bool $showLabel = true;
    public bool $required = true;
    protected array $requiredFields = ["id"];

    public function parseProps($node, $data): void
    {
        $inputId = $this->id;
        $value = old($inputId,  $this->node->value ?? $data[$inputId] ?? "");
        $this->value = is_object($value) || is_array($value) ? json_encode($value) : $value;

        $this->label = $node->label ?? $this->label;
        $this->showLabel = $node->showLabel ?? $this->showLabel;
        $this->placeholder = $node->placeholder ?? $this->placeholder;
    }
}
