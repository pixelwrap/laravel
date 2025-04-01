<?php

namespace PixelWrap\Laravel\Facades\Support;

use ArrayAccess;
use Traversable;
use ArrayIterator;
use IteratorAggregate;

class Row implements ArrayAccess, IteratorAggregate
{
    protected array $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->data);
    }

    public function toArray(): array{
        return $this->data;
    }
}
