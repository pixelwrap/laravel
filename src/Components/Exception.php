<?php

namespace PixelWrap\Laravel\Components;

use PixelWrap\Laravel\Traits\HasText;

class Exception extends ComponentContract
{
    protected array $requiredFields = [];
    public array $errors = [];
    public function parseProps($node, $data): void
    {
        $this->errors = $data['errors'] ?? $this->errors;
    }
}
