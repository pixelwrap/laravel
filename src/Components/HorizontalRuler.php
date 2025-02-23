<?php

namespace PixelWrap\Laravel\Components;

use PixelWrap\Laravel\Support\InvalidValue;

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
