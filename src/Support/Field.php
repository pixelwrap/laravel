<?php

namespace PixelWrap\Laravel\Facades\Support;

use PixelWrap\Laravel\Facades\Traits\HasText;

class Field
{
    use HasText;

    public string $classes;
    public string $key;
    public string $label;
    public array $filters;

    public function __construct($key, $label, $alignment, $filters)
    {
        $this->key = $key;
        $this->label = $label;
        $this->filters = $filters;
        $this->classes = "px-3 py-2 text-{$alignment}";
    }

    public function value($data)
    {
        $data = is_array($data) ? $data : $data->toArray();
        $val = interpolateString("{{$this->key}}", $data) ?? null;
        return filter($this->filters, $val);
    }
}
