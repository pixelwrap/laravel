<?php

namespace PixelWrap\Laravel\Facades\Traits;

use PixelWrap\Laravel\Facades\PixelWrapRenderer;

trait HasAction
{
    public function buildActions($actions)
    {
        foreach ($actions as $action) {
            $node = (object) [
                ...get_object_vars($action),
                "type" => "Button",
                "action" => $action,
                "type" => "Button",
                "variant" => $action->variant ?? "primary",
                "name" => $action->name ?? "",
                "size" => $action->size ?? "small",
                "role" => $action->role ?? "link",
                "icon" => $action->icon ?? null,
                "showLabel" => ($action->variant ?? null) === "icon" ? false : $action->showLabel ?? true,
                "label" => $action->label ?? "Label not set",
                "value" => $action->value ?? null,
                "show-if" => $action->{"show-if"} ?? [],
                "hide-if" => $action->{"hide-if"} ?? [],
            ];

            if (mb_strtolower($action->role) === "form") {
                $node->role = "submit";
                $node = (object) [
                    "type" => "Form",
                    "action" => $action,
                    "method" => $action->method ?? "post",
                    "nodes" => [$node],
                ];
            }
            $this->actions[] = PixelWrapRenderer::from($this->data, $node, $this->theme);
        }
    }
}
