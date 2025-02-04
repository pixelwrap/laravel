<?php

namespace PixelWrap\Laravel\Components;

use PixelWrap\Laravel\Traits\HasLink;

class Form extends CompoundComponent
{
    use HasLink;

    public string $action;
    public string $method = "post";
    protected array $requiredFields = ["nodes", "method", "action"];

    public function parseProps($data):void
    {
        parent::parseProps($data);
        $this->method = $this->node->method ?? $this->method;
        $this->action = $this->buildLink($data);
    }
}
