<?php

namespace PixelWrap\Laravel\Facades\Components;

class Toggle extends Text
{
    public string $value = "";
    public string $default = "";
    public bool $disabled = false;

    protected array $requiredFields = ["id"];

    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $inputId = $this->id;
        $this->default = $node->default ?? $this->default;

        $this->disabled = $node->disabled ?? $this->disabled;
        $this->name = $node->name ?? ($this->id ?? $this->name);

        $this->value = old($inputId, $this->node->value ?? ($data[$inputId] ?? false));
    }

    public function value()
    {
        return $this->value === "1";
    }
}
