<?php

namespace PixelWrap\Laravel\Components;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class Table extends ComponentContract
{
    public bool $isPaginated = false;
    public int $fieldCount;
    public string $highlight;
    public int $indexed;
    public array $actions;
    public array $fields;
    public array|LengthAwarePaginator|Paginator $dataset;
    protected array $requiredFields = ["fields", "dataset"];

    protected function parseProps($data): void
    {
        $table = $this->node;
        $this->fields = $fields = $table->fields;
        $dataset = $table->dataset;
        $this->dataset = $data;
        $this->indexed = $table->index ?? true;
        $actions = $table->actions ?? [];
        $this->highlight = $table->highlight ?? "";
        $this->isPaginated = $dataset instanceof LengthAwarePaginator || $dataset instanceof Paginator;
        $firstField = $fields[0];
        if (is_object($firstField)) {
            $this->fieldCount = count(get_object_vars($fields));
            foreach ($fields as $index => $field) {
                if (!isset($field->key) || !isset($field->label)) {
                    $this->errors[] = sprintf("Key and Label for field %s must be set. Please check if your template is compliant with the specification.", $index + 1);
                } else {
                    dd($fields);
                }
            }
        } else {
            $this->fieldCount = count($fields);
        }
    }
}
