<?php

namespace PixelWrap\Laravel\Components;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use PixelWrap\Laravel\PixelWrapRenderer;
use PixelWrap\Laravel\Support\Dataset;

class Listing extends CompoundComponent
{
    public bool $isPaginated = false;
    public  Paginator|LengthAwarePaginator $paginator;
    public mixed $dataset;
    protected array $requiredFields = ["dataset", "nodes"];

    public function parseProps($listing, $data): void
    {
        parent::parseProps($listing, $data);
        if (isset($listing->dataset)){
            if(isset($data[$listing->dataset])) {
                $dataset           = $data[$listing->dataset];
                $this->dataset     = new Dataset($dataset);
                $this->paginator   = $dataset;
                $this->isPaginated = $dataset instanceof Paginator || $dataset instanceof LengthAwarePaginator;
            } else {
                $this->errors[] = sprintf("A dataset called %s not found in context", $listing->dataset);
            }
        }
    }
}
