<?php

namespace PixelWrap\Laravel\Facades\Components;

use Illuminate\Contracts\View\View;
use PixelWrap\Laravel\Facades\Traits\HasLink;

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
    }

    public function render($args = []): View|null
    {
        if (isset($this->node->action)) {
            $this->action = $this->buildLink($this->node->action, [
                ...$this->data,
                ...$args,
            ]);
        }
        return parent::render($args);
    }
}
