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
                    $label = $link->label ?? 'Not Set';
                    $url = $link->url ?? 'Not Set';
                    $this->links[] = Link::from($label, $url, $link->icon ?? null);
                }
            } else {
                $this->errors[] = "Links should be an array";
            }
        }
    }
}
