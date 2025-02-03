<?php

namespace PixelWrap\Laravel\Components;

class Form extends CompoundComponent
{
    protected array $requiredFields = ["nodes", "method", "action"];

    public function parseProps($data):void
    {
        parent::parseProps($data);
    }
}
