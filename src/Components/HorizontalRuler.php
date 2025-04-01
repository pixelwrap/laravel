<?php

namespace PixelWrap\Laravel\Facades\Components;

use PixelWrap\Laravel\Facades\Support\InvalidValue;

class HorizontalRuler extends ComponentContract
{
    /**
     * @throws InvalidValue
     */
    public function __construct($data, $node, $theme = "tailwind")
    {
        parent::__construct($data, $node, $theme);
        $this->template = "hr";
    }

    protected function parseProps($node, $data): void {}
}
