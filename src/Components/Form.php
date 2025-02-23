<?php

namespace PixelWrap\Laravel\Components;

use PixelWrap\Laravel\Traits\HasLink;

class Form extends CompoundComponent
{
    use HasLink;

    public string $action;
    public string $method = "post";
    public bool $autocomplete = false;
    protected array $requiredFields = ["nodes", "method", "action"];
    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $this->method = $node->method ?? $this->method;
        $this->action = $this->buildLink($node->action ?? $this->action, $data);
    }
}
