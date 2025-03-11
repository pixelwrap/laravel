<?php

namespace PixelWrap\Laravel\Components;

class InputContract extends Text
{
    public string $id;
    public string $placeholder = "";
    public string $value = "";
    public string $default = "";
    public bool $showLabel = true;
    public bool $required = true;
    public bool $disabled = false;

    protected array $requiredFields = ["id"];

    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $inputId = $this->id;
        $this->default = $node->default ?? $this->default;

        $this->showLabel    = $node->showLabel   ?? $this->showLabel;
        $this->placeholder  = $node->placeholder ?? $this->placeholder;
        $this->required     = $node->required    ?? $this->required;
        $this->disabled     = $node->disabled    ?? $this->disabled;
        $this->name         = $node->name        ?? $this->id ?? $this->name;

        $value          = old($inputId,  $this->node->value ?? $data[$inputId] ?? "");
        $this->value    = is_object($value)  || is_array($value) ? json_encode($value) : $value;
        $this->value    = $this->value ===   "" ? $this->default : $this->value;
    }


    public function placeholder($args = [])
    {
        return interpolateString($this->placeholder, [...$args, ...$this->data]);
    }
}
