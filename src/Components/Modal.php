<?php

namespace PixelWrap\Laravel\Components;

use PixelWrap\Laravel\PixelWrapRenderer;
use PixelWrap\Laravel\Traits\HasText;

class Modal extends CompoundComponent
{
    use HasText;

    public $label = "Title Not Set";
    public $padding = "x-smaller y-smaller";
    public $sizeClasses = "";
    public $footer = null;
    public $static = false;
    public $showClose = true;

    protected array $requiredFields = [];

    public function parseProps($modal, $data): void
    {
        parent::parseProps($modal, $data);
        $size = mb_strtolower($modal->size ?? "default");
        $this->label = $modal->label ?? $this->label;
        $this->showClose = $modal->showClose ?? $this->showClose;
        $this->static = $modal->static ?? $this->static;
        $this->id = $modal->id ?? sprintf("modal_%s", uniqid());
        $options = $this->themeDefinitions["modalSizes"];
        if (!in_array($size, array_keys($options))) {
            $this->errors[] = sprintf("\"%s\" only allows one of %s. Found '%s'.", mb_ucfirst($size), implode(", ", $options), $size);
        } else {
            $this->addClass($options[$size], "sizeClasses");
        }
        if (isset($modal->footer)) {
            if ($modal->footer != null && isset($modal->footer->nodes)) {
                $node = ["type" => "Row", "gap" => "smaller", ...get_object_vars($modal->footer)];
                $this->footer = PixelWrapRenderer::from($data, $node, $this->theme);
            }
        } else {
            $node = [
                "type" => "Row",
                "padding" => $this->padding,
                "nodes" => [
                    ["type" => "Button", "role" => "button", "size" => "big", "padding" => "x-big", "label" => "Dismiss", "modalHide" => $this->id],
                ],
            ];
            $this->footer = PixelWrapRenderer::from($data, $node, $this->theme);
        }
    }
}
