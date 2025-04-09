<?php

namespace PixelWrap\Laravel\Components;

class PixelIcon extends ComponentContract
{
    public string $name = "";
    protected array $requiredFields = ["name"];

    public bool $rounding = false;
    public function parseProps($node, $data): void
    {
        $this->name = $node->name ?? $this->name;
        $size = mb_strtolower($node->size ?? "small");
        $validations = [
            "size" => array_keys($this->themeDefinitions["iconSizes"]),
        ];
        foreach ($validations as $key => $options) {
            if (!in_array($$key, $options)) {
                $this->errors[] = sprintf("\"%s\" only allows one of %s. Found '%s'.", mb_ucfirst($key), implode(", ", $options), $$key);
            }
        }

        $this->addClass($this->themeDefinitions["iconSizes"][$size] ?? '');
    }

    public function icon($args = []): string
    {
        return interpolateString($this->name, [...$this->data,...$args]);
    }
}
