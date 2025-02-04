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
    public string $show = "name";
    public string $list = "name";
    public ComponentContract $input;

    /**
     * @throws NodeNotImplemented
     */
    public function parseProps($data): void
    {
        parent::parseProps($data);
        $inputId =  sprintf("autocomplete-input-%s",$this->id);
        $input = (object) [
            "type"          => "Input",
            "id"            => $inputId,
            "label"         => $this->label,
            "autocomplete"  => false,
            "value"         => old($inputId, interpolateString($typeahead->value ?? "", $data))
        ];
        $this->query    =  $this->node->query ??  $this->query;
        $this->attach   =  $this->node->attach ??  $this->attach;
        $this->show     =  $this->node->show ??  $this->show;
        $this->list     =  $this->node->list ??  $this->list;
        $this->input    =  PixelWrapRenderer::from($data, $input, $this->theme);
        $this->action   = $this->buildLink($data);
    }
}
