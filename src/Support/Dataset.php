<?php

namespace PixelWrap\Laravel\Support;

use ArrayAccess;
use Traversable;
use ArrayIterator;
use IteratorAggregate;

class Dataset implements \ArrayAccess, \IteratorAggregate
{
    public array $rows = [];

    public function __construct($data = [])
    {
        foreach ($data as $value) {
            $this->rows[] = new Row($value);
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->rows[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->rows[$offset];
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->rows[] = $value;
        } else {
            $this->rows[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->rows[$offset]);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->rows);
    }
}
