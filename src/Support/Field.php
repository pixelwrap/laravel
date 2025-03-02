<?php

namespace PixelWrap\Laravel\Support;

use ArrayAccess;
use Traversable;
use ArrayIterator;
use IteratorAggregate;

class Field
{
    public string $key;
    public string $label;
    public array $filters;

    public function __construct($key, $label, $filters)
    {
        $this->key      = $key;
        $this->label    = $label;
        $this->filters  = $filters;
    }

    public function value($data)
    {
        $val = $data[$this->key] ?? null;
        return filter($this->filters, $val);
    }
}
