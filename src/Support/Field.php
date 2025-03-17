<?php

namespace PixelWrap\Laravel\Support;

use ArrayAccess;
use PixelWrap\Laravel\Traits\HasText;
use Traversable;
use ArrayIterator;
use IteratorAggregate;

class Field
{
    use HasText;

    public string $classes;
    public string $key;
    public string $label;
    public array $filters;

    public function __construct($key, $label, $alignment, $filters)
    {
        $this->key      = $key;
        $this->label    = $label;
        $this->filters  = $filters;
        $this->classes = "px-3 py-2 text-{$alignment}";
    }

    public function value($data)
    {
        $val = $data[$this->key] ?? null;
        return filter($this->filters, $val);
    }
}
