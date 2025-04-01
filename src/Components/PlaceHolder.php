<?php

namespace PixelWrap\Laravel\Facades\Components;

use Illuminate\Contracts\View\View;
use PixelWrap\Laravel\Facades\Support\InvalidValue;

class PlaceHolder extends ComponentContract
{
    /**
     * @throws InvalidValue
     */
    public function __construct($data, $node, $theme = "tailwind")
    {
        parent::__construct($data, $node, $theme);
        $this->template = "null";
    }

    protected function parseProps($node, $data): void{}
}
