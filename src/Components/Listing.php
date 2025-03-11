<?php

namespace PixelWrap\Laravel\Components;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use PixelWrap\Laravel\PixelWrapRenderer;
use PixelWrap\Laravel\Support\Dataset;

class Listing extends Grid
{
    public bool $isPaginated = false;
    public  Paginator|LengthAwarePaginator $paginator;
    public mixed $dataset;
    protected array $requiredFields = ["dataset", "nodes"];

    public function parseProps($listing, $data): void
    {
        parent::parseProps($listing, $data);
        if (isset($listing->dataset)){
            $datasetName = interpolateString($listing->dataset, $data);
            if(isset($data[$datasetName])) {
                $dataset           = $data[$datasetName];
                $this->dataset     = new Dataset($dataset);
                $this->isPaginated = $dataset instanceof Paginator || $dataset instanceof LengthAwarePaginator;
                if($this->isPaginated){
                    $this->paginator = $dataset;
                }
            } else {
                $this->errors[] = sprintf("A dataset called %s not found in context", $datasetName);
            }
        }
    }
}
