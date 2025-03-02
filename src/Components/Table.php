<?php

namespace PixelWrap\Laravel\Components;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use PixelWrap\Laravel\PixelWrapRenderer;
use PixelWrap\Laravel\Support\Dataset;
use PixelWrap\Laravel\Support\Field;

class Table extends Listing
{
    public int $fieldCount;
    public string $highlight;
    public bool $indexed;
    public bool $aggregated = false;
    public array $aggregate = [];
    public array $actions = [];
    public array $fields = [];
    protected array $requiredFields = ["fields", "dataset"];

    public function parseProps($table, $data): void
    {
        $table->nodes = [];
        parent::parseProps($table, $data);
        $fields = $table->fields;
        $this->indexed = $table->indexed ?? true;
        $actions = $table->actions ?? [];
        $this->highlight = $table->highlight ?? "";
        if (is_object($fields)) {
            $fields = get_object_vars($fields);
            foreach ($fields as $key => $label) {
                $this->fields[$key] = new Field($key, $label, []);
            }
        } else {
            foreach ($fields as $index => $field) {
                if (!isset($field->key) || !isset($field->label)) {
                    $this->errors[] = sprintf("Key and Label for field %s must be set. Please check if your template is compliant with the specification.", $index + 1);
                } else {
                    $this->fields[$field->key] = new Field($field->key, $field->label, explode("|", $field->filters ?? null));
                    if(isset($field->aggregated) && isset($this->dataset)) {
                        $aggregates = is_array($field->aggregated) ? $field->aggregated : [$field->aggregated];
                        $allowed = ["sum", "avg", "max", "min"];
                        foreach ($aggregates as $aggregate) {
                            if(in_array($aggregate, $allowed)) {
                                $this->aggregated = true;
                                $this->aggregate[$aggregate][$field->key] = collect($this->dataset)->{$aggregate}($field->key);
                            }else{
                                $this->errors[] = sprintf("Aggregated must be one of %s. Please check if your template is compliant with the specification.", implode(", ", $allowed));
                            }
                        }
                    }
                }
            }
        }
        $this->fieldCount = count($this->fields);
        foreach ($actions as $action) {
            if (mb_strtolower($action->role) === "form") {
                $node = (object)[
                    "type"   => "Form",
                    "action" => $action,
                    "method" => $action->method ?? "post",
                    "nodes"  => [
                        (object)[
                            "type"      => "Button",
                            "variant"   => $action->variant ?? "primary",
                            "size"      => $action->size ?? "small",
                            "role"      => "submit",
                            "label"     => $action->label,
                            "value"     => $action->value ?? null,
                        ]
                    ]
                ];
            } else {
                $node = (object)[
                    "type"      => "Button",
                    "action"    => $action,
                    "type"      => "Button",
                    "variant"   => $action->variant ?? "primary",
                    "size"      => $action->size ?? "small",
                    "role"      => $action->role ?? "link",
                    "label"     => $action->label,
                    "value"     => $action->value ?? null,
                    "show-if"   => $action->{"show-if"} ?? [],
                    "hide-if"   => $action->{"hide-if"} ?? [],
                ];
            }
            $this->actions[] = PixelWrapRenderer::from($data, $node, $this->theme);;
        }
    }
}
