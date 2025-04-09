<?php

namespace PixelWrap\Laravel\Components;

use Illuminate\Contracts\View\View;
use PixelWrap\Laravel\Traits\HasLink;

class Button extends Text
{
    use HasLink;

    public string $role = "submit";
    public string $props = "";
    public string $value = "";
    public string $link = "";
    public string $icon = "";
    public string $name = "action";
    public bool $showLabel = true;
    public mixed $action;
    public bool $rounding = false;

    public function parseProps($node, $data): void
    {
        parent::parseProps($node, $data);
        $size = mb_strtolower($node->size ?? "small");
        $role = mb_strtolower($node->role ?? $this->role);
        $variant = mb_strtolower($node->variant ?? "primary");
        $validations = [
            "role" => ["link", "reset", "button", "submit"],
            "size" => array_keys($this->themeDefinitions["buttonSizes"]),
            "variant" => array_keys($this->themeDefinitions["buttonVariants"]),
        ];
        foreach ($validations as $key => $options) {
            if (!in_array($$key, $options)) {
                $this->errors[] = sprintf("\"%s\" only allows one of %s. Found '%s'.", mb_ucfirst($key), implode(", ", $options), $$key);
            }
        }
        $this->icon = $node->icon ?? $this->icon;
        $this->value = $node->value ?? $this->value;
        $this->role = $role;
        $this->name = $node->name ?? ($this->id ?? $this->name);
        $this->showLabel = $node->showLabel ?? $this->showLabel;

        $this->addClass($this->themeDefinitions["buttonVariants"][$variant]);
        if ($variant === "icon") {
            if (!isset($node->icon)) {
                $message = "Icon must be set. Please check if your template is compliant with the specification.";
                $this->errors[] = $message;
            }
            $this->addClass($this->themeDefinitions["iconSizes"][$size]);
        } else {
            $this->addClass($this->themeDefinitions["borderRadiusOptions"][$this->rounded]);
            $this->addClass($this->themeDefinitions["buttonSizes"][$size]);
        }
        if ($this->role === "link") {
            $field = "action";
            if (isset($node->{$field})) {
                $this->action = $node->action;
            } else {
                $message = "Action must be set. Please check if your template is compliant with the specification.";
                $this->errors[] = $message;
            }
        }
    }

    public function render($args = []): View|null
    {
        if ($this->role === "link") {
            if (isset($this->action)) {
                $this->link = $this->buildLink($this->action, [...$this->data, ...$args]);
            } else {
                $this->errors[] = "Action must be set. Please check if your template is compliant with the specification.";
            }
        } elseif ($this->role === "button") {
            if ($this->node->{'modalHide'} ?? false) {
                $id =  interpolateString($this->node->{'modalHide'}, [...($this->data ?? []), ...$args]);
                $this->props .= sprintf(" data-modal-hide=%s", $id);
            }
            if ($this->node->{'modalShow'} ?? false) {
                $id =  interpolateString($this->node->{'modalShow'}, [...($this->data ?? []), ...$args]);
                $this->props .= sprintf(" data-modal-show=%s", $id);
            }
            if ($this->node->{'modalToggle'} ?? false) {
                $id =  interpolateString($this->node->{'modalToggle'}, [...($this->data ?? []), ...$args]);
                $this->props .= sprintf(" data-modal-toggle=%s", $id);
            }
        }
        return parent::render($args);
    }
}
