<?php

namespace PixelWrap\Laravel\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use PixelWrap\Laravel\Support\Dataset;

class Listing extends Grid
{
    public bool $isPaginated = false;
    public bool $showEmptyMessage = true;
    public Paginator|LengthAwarePaginator $paginator;
    public mixed $dataset;
    protected array $requiredFields = ["dataset", "nodes"];

    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $this->showEmptyMessage = $node->showEmptyMessage ?? $this->showEmptyMessage;
    }

    public function parseDataset($args): void
    {
        $data = [...$this->data, ...$args];
        $datasetName = interpolateString($this->node->dataset, $data);
        if (isset($data[$datasetName])) {
            $dataset = $data[$datasetName];
            $this->dataset = new Dataset($dataset);
            $this->isPaginated = $dataset instanceof Paginator || $dataset instanceof LengthAwarePaginator;
            if ($this->isPaginated) {
                $this->paginator = $dataset;
            }
        } else {
            $context = collect($data)->keys()->map(fn($k) => "'{$k}'")->toArray();
            $this->errors[] = sprintf("Dataset '%s' not found in context. Found %s.", $datasetName, implode(", ", $context));
        }
    }

    public function setDataset($args)
    {
        if (isset($this->node->dataset)) {
            $this->parseDataset($args);
        }
    }

    public function render($args = []): View|null
    {
        $this->setDataset($args);
        return parent::render($args);
    }
}
