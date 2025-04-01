<?php

namespace PixelWrap\Laravel\Facades\Traits;

use League\Uri\BaseUri;
use League\Uri\Http;
use League\Uri\QueryString;

trait HasText
{
    public function text($args)
    {
        $value = interpolateString($this->label, [...$args, ...$this->data ?? []]);
        return filter($this->filters, $value);
    }
}
