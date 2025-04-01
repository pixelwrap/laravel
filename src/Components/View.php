<?php

namespace PixelWrap\Laravel\Components;

use PixelWrap\Laravel\Traits\HasText;

class View extends ComponentContract
{
    use HasText;

    protected array $requiredFields = ["view"];
    public $view = null;

    public function parseProps($node, $data): void
    {
        $this->view = $node->view ?? $this->view;
    }

    public function render($args = []): \Illuminate\Contracts\View\View|null
    {
        return view($this->view, $args);
    }
}
