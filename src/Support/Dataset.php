<?php

namespace PixelWrap\Laravel\Support;

use ArrayAccess;
use Countable;
use Traversable;
use ArrayIterator;
use IteratorAggregate;

class Dataset implements \ArrayAccess, \IteratorAggregate, Countable
{
    public array $rows = [];

    public function __construct($data = [])
    {
        foreach ($data as $value) {
            if (is_object($value)) {
                if (method_exists($value, 'toArray')) {
                    $value = $value->toArray();
                } else {
                    $value = get_object_vars($value);
                }
            }
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

    public function count()
    {
        return count($this->rows);
    }

    public function toArray(): array
    {
        return $this->rows;
    }
}
