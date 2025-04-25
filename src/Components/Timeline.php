<?php

namespace PixelWrap\Laravel\Components;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use PixelWrap\Laravel\Support\Dataset;
use PixelWrap\Laravel\Traits\HasText;

class Timeline extends CompoundComponent
{
    use HasText;

    public string $orientation = "vertical";
    public mixed $dataset = null;
    public bool $rounding = false;
    public string $iconSize = "small";

    public function parseProps($node, $data): void
    {
        if (!in_array($node->orientation ?? $this->orientation, ["horizontal", "vertical"])) {
            $this->errors[] = "Orientation is must be set to 'horizontal' or 'vertical'";
        } else {
            $this->orientation = $node->orientation ?? $this->orientation;
        }
        $sizes = $this->themeDefinitions[$this->orientation === "vertical" ? 'verticalTimelineIconSizes' : 'horizontalTimelineIconSizes'];
        $options = array_keys($sizes);
        $val = $node->iconSize ?? $this->iconSize;
        if (!in_array($val, $options)) {
            $this->errors[] = sprintf("Icon size must be one of %s, Found '%s'", $val, implode("', '", $options));
        } else {
            $this->addClass($sizes[$val], "iconSizeClasses");
        }

        $this->dataset = $node->dataset ?? $this->dataset;
        if ($this->dataset) {
            if (isset($data[$this->dataset])) {
                $dataset = $data[$this->dataset];
                $this->dataset = new Dataset($dataset);
            } else {
                $this->errors[] = sprintf("Dataset '%s' not found in context. Found %s.", $this->dataset, implode(", ", array_keys($data)));
            }
        }
        parent::parseProps($node, $data);
    }

}
