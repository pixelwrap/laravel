<?php

namespace PixelWrap\Laravel\Components;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use PixelWrap\Laravel\PixelWrapRenderer;
use PixelWrap\Laravel\Support\Dataset;
use PixelWrap\Laravel\Support\Field;
use PixelWrap\Laravel\Traits\HasAction;

class Table extends Listing
{
    use HasAction;
    public int $fieldCount      = 0;
    public string $highlight    = "";
    public bool $indexed        = true;
    public bool $aggregated     = false;
    public bool $showHeader     = true;
    public array $headers       = [];
    public array $aggregate     = [];
    public array $actions       = [];
    public array $fields        = [];
    public string $variant      = "primary";
    public string $emptyMessage = "Nothing here.";
    protected array $requiredFields = ["fields", "dataset"];

    public function parseProps($table, $data): void
    {
        $table->nodes = [];
        if(isset($table->dataset) && is_array($table->dataset)) {
            $dataset = [];
            $names = $table->dataset;
            foreach ($names as $index=> $dataset) {
                $table->dataset = $dataset;
                parent::parseProps($table, $data);
                if(isset($this->dataset)) {
                    $datasets[$dataset] = $this->dataset;
                    $this->headers[$dataset] = $table->headers[$index] ?? "";
                }
            }
            $this->dataset = $datasets;
        }else if(isset($table->dataset)) {
            parent::parseProps($table, $data);
            if(isset($this->dataset)) {
                $this->dataset   = [$this->dataset];
            }
        }
        $fields              = $table->fields;
        $this->indexed       = $table->indexed       ?? $this->indexed;
        $this->showHeader    = $table->showHeader    ?? $this->showHeader;
        $this->highlight     = $table->highlight     ?? $this->highlight;
        $this->emptyMessage  = $table->emptyMessage  ?? $this->emptyMessage;
        $this->variant       = $table->variant       ?? $this->variant;

        $actions = $table->actions ?? [];
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
                        $allowed = ["sum" => "Total", "avg" => "Average", "max" => "Maximum", "min" => "Minimum"];
                        foreach ($aggregates as $aggregate) {
                            $this->aggregated = true;
                            if(in_array($aggregate, array_keys($allowed))) {
                                if(is_array($this->dataset)) {
                                    foreach ($this->dataset as $datasetIndex => $dataset) {
                                        $this->aggregate[$datasetIndex][$allowed[$aggregate]][$field->key] = collect($dataset)->map(fn($d) => $d->toArray())->{$aggregate}($field->key);
                                    }
                                }else{
                                    $this->aggregate[][$allowed[$aggregate]][$field->key] = collect($this->dataset)->map(fn($d) => $d->toArray())->{$aggregate}($field->key);
                                }
                            }else{
                                $this->errors[] = sprintf("Aggregated must be one of %s. Please check if your template is compliant with the specification.", implode(", ", $allowed));
                            }
                        }
                    }
                }
            }
        }
        $this->fieldCount = count($this->fields);
        $this->buildActions($actions);
        $this->addClass('table-auto w-full text-sm text-left rtl:text-right text-gray-800 dark:text-gray-200');
        if($this->variant === "primary") {
            $this->addClass('text-xs font-bold text-gray-700 uppercase bg-gray-300 dark:bg-gray-600 dark:text-gray-100', 'headingClasses');
            $this->addClass('odd:bg-gray-50 odd:dark:bg-gray-900 even:bg-gray-100 even:dark:bg-gray-700 border-b dark:border-gray-700 border-gray-200', 'rowClasses');
        }else if($this->variant === "secondary"){
            $this->addClass('odd:bg-gray-50 odd:dark:bg-gray-900 even:bg-gray-100 even:dark:bg-gray-700 dark:border-gray-700 border-gray-200', 'rowClasses');
//            $this->addClass('text-xs font-bold text-gray-700 uppercase bg-gray-300 dark:bg-gray-600 dark:text-gray-100', 'headingClasses');
        }
    }
}
