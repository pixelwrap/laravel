<?php

namespace PixelWrap\Laravel\Components;

use PixelWrap\Laravel\Support\Link;

class Breadcrumb extends ComponentContract
{
    public $links = [];
    protected array $requiredFields = ["links"];

    public bool $rounding = false;

    public function parseProps($node, $data): void
    {
        if (isset($node->links)) {
            if (is_array($node->links)) {
                foreach ($node->links as $link) {
                    $this->links[] = Link::from($link);
                }
            } else {
                $this->errors[] = "Links should be an array";
            }
        }
    }
}
