<?php

namespace PixelWrap\Laravel\Facades\Components;

use PixelWrap\Laravel\Facades\Traits\HasText;

class Exception extends ComponentContract
{
    protected array $requiredFields = [];
    public array $errors = [];
    public function parseProps($node, $data): void
    {
        $this->errors = $data['errors'] ?? $this->errors;
    }
}
