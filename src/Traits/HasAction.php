<?php

namespace PixelWrap\Laravel\Traits;

use PixelWrap\Laravel\PixelWrapRenderer;

trait HasAction
{
    public function buildActions($actions)
    {
        foreach ($actions as $action) {
            $node = (object) [
                ...get_object_vars($action),
                "type" => "Button",
                "action" => $action,
                "variant" => $action->variant ?? "primary",
                "name" => $action->name ?? "",
                "size" => $action->size ?? "small",
                "role" => $action->role ?? "link",
                "icon" => $action->icon ?? null,
                "showLabel" => ($action->variant ?? null) === "icon" ? false : $action->showLabel ?? true,
                "label" => $action->label ?? "Label not set",
                "value" => $action->value ?? null,
                "showIf" => $action->{"showIf"} ?? [],
                "hideIf" => $action->{"hideIf"} ?? [],
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
            $this->actions[] = PixelWrapRenderer::from($this->data, $node, $this->theme, $this->rounded);
        }
    }
}
