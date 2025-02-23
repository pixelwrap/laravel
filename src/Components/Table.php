<?php

namespace PixelWrap\Laravel\Components;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use PixelWrap\Laravel\PixelWrapRenderer;

class Table extends ComponentContract
{
    public bool $isPaginated = false;
    public int $fieldCount;
    public string $highlight;
    public bool $indexed;
    public array $actions;
    public array $fields = [];
    public array|LengthAwarePaginator|Paginator|Collection $dataset;
    protected array $requiredFields = ["fields", "dataset"];

    protected function parseProps($table, $data): void
    {
        $fields = $table->fields;
        $this->dataset = $dataset = $data[$table->dataset];
        $this->indexed = $table->indexed ?? true;
        $actions = $table->actions ?? [];
        $this->highlight = $table->highlight ?? "";
        $this->isPaginated = $dataset instanceof LengthAwarePaginator || $dataset instanceof Paginator;
        if (is_object($fields)) {
            $this->fields = get_object_vars($fields);
        } else {
            foreach ($fields as $index => $field) {
                if (!isset($field->key) || !isset($field->label)) {
                    $this->errors[] = sprintf("Key and Label for field %s must be set. Please check if your template is compliant with the specification.", $index + 1);
                } else {
                    $this->fields[$field->key] = $field->label;
                }
            }
        }
        $this->fieldCount = count($this->fields);
        foreach ($actions as $action) {
            $button = (object) [
                "type"    => "Button",
                "variant" => $action->variant ?? "primary",
                "size"    => $action->size ?? "small",
                "role"    => "link",
                "label"   => $action->label,
                "action"  => (object) [
                    "link"   => $action->link,
                    "params" => $action->params,
                ]
            ];
            $this->actions[] = PixelWrapRenderer::from($data, $button, $this->theme);;
        }
    }
}
