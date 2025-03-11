<?php

namespace PixelWrap\Laravel\Components;


use PixelWrap\Laravel\PixelWrapRenderer;
use PixelWrap\Laravel\Support\NodeNotImplemented;
use PixelWrap\Laravel\Traits\HasLink;

class TypeAhead extends Input
{
    use HasLink;
    protected array $requiredFields = ["label", "action", "id"];
    public string $action;
    public string $query = "q";
    public string $attach = "attach";
    public string $list = "name";
    public string $show = "name";
    public ComponentContract $input;

    /**
     * @throws NodeNotImplemented
     */
    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $input = (object) [
            "type"          => "Input",
            "id"            => sprintf("type-ahead-%s", $node->id),
            "label"         => $node->label,
            "placeholder"   => $node->placeholder ?? $this->placeholder,
            "autocomplete"  => false,
            "required"      => $node->required ?? $this->required,
            "disabled"      => $node->disabled ?? $this->disabled,
            "value"         => old(sprintf("type-ahead-%s", $node->id), interpolateString($node->currentLabel ?? "", $data))
        ];

        // What to send to server as query field
        $this->query    =  $node->query  ??  $this->query;
        // Field we attach as value to input field from results.
        $this->attach   =  $node->attach ??  $this->attach;
        // What field to show on input field.
        $this->show     =  $node->show   ??  $this->show;
        // What field to show on search results window.
        $this->list     =  $node->list   ??  $this->list;

        $this->input    =  PixelWrapRenderer::from($data, $input, $this->theme);
        if(isset($node->action)) {
            $this->action = $this->buildLink($node->action, $data);
        }
    }
}
