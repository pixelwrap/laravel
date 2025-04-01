<?php

use Illuminate\Support\Str;
use Illuminate\View\View;
use PixelWrap\Laravel\Facades\PixelWrapRenderer;
use Symfony\Component\Yaml\Yaml;
use PixelWrap\Laravel\Facades\Support\InvalidValue;
use PixelWrap\Laravel\Facades\Support\NodeNotImplemented;

/**
 * @throws Exception
 */
function raise($code, $message)
{
    throw match ($code) {
        "not_implemented" => new NodeNotImplemented($message, null),
        "invalid" => new InvalidValue($message, null),
        default => new Exception($message),
    };
}

function explode_prop($prop): array
{
    // Split by space or comma
    return preg_split("/[\s,]+/", $prop, -1, PREG_SPLIT_NO_EMPTY);
}

function pixelwrap_resource($path = null): string
{
    $base = realpath(__DIR__ . "/../../resources/views");
    if ($path) {
        return sprintf("%s/%s", $base, $path);
    }
    return $base;
}

function renderPixelWrapPage($page, $data = []): View
{
    return app("pixelwrap")->render($page, $data);
}

function pixelwrap(): PixelWrapRenderer
{
    return app("pixelwrap");
}

function pixel_insert_icon($icon)
{
    foreach (app("pixelwrap")->paths as $path) {
        $file = sprintf("%s/%s.svg", $path, $icon);
        if (file_exists($file)) {
            return file_get_contents($file);
        }
    }
    throw new Exception(sprintf("Unable to locate pixel icon '%s'.", $icon));
}

function renderComponentSource($component): string
{
    if (is_string($component)) {
        return $component;
    } else {
        if ($component->ignoreNodes && isset($component->nodes)) {
            $component->nodes = ["section redacted"];
        }
        $data = json_decode(json_encode($component->node), true);
        return Yaml::dump($data, 8, 2, Yaml::DUMP_OBJECT);
    }
}

function interpolateString($format, $variables): string
{
    // This pattern matches placeholders like {invoiceable-type} or {invoiceable_type}
    // by allowing letters, digits, underscore, dash, and dot.
    $pattern = "/\{([\w.\-]+)\}/";

    return preg_replace_callback(
        $pattern,
        function ($matches) use ($variables) {
            $keys = explode(".", $matches[1]);
            $value = $variables;

            foreach ($keys as $key) {
                if (is_object($value) && isset($value->$key)) {
                    $value = $value->$key;
                } elseif (is_array($value) && array_key_exists($key, $value)) {
                    $value = $value[$key];
                } else {
                    // Return an empty string if any key isn't found
                    return "";
                }
            }

            // Cast to string to avoid issues if $value is not a string
            return (string) $value;
        },
        $format
    );
}

function filter($filters, $value): string|null
{
    foreach ($filters as $rawFilter) {
        if (Str::contains($rawFilter, ":")) {
            [$filter, $params] = explode(":", $rawFilter);
            $params = explode(",", $params);
        } else {
            $filter = $rawFilter;
            $params = [];
        }
        switch ($filter) {
            case "plural":
                if (is_numeric($value)) {
                    $value = sprintf("%s %s", $value, Str::plural($params[0], $value));
                }
                break;
            case "keymap":
                $mapped = [];
                for ($i = 0; $i < count($params); $i += 2) {
                    $key = trim($params[$i]);
                    $val = trim($params[$i + 1]);
                    $mapped[$key] = $val;
                }
                $value = $mapped[$value] ?? $value;
                break;
            case "bool":
            case "boolean":
                if (is_numeric($value)) {
                    $params = [...$params, "False", "True"];
                    $value = $params[$value];
                }
                break;
            case "number":
                if (is_numeric($value)) {
                    $value = number_format(floatval($value), 2);
                }
                break;
            case "lowercase":
                $value = Str::lower($value);
                break;
            case "uppercase":
                $value = Str::upper($value);
                break;
            case "null":
                if (!$value) {
                    $params = [...$params, "-"];
                    $value = $params[0];
                }
                break;
            case "capitalize":
            case "capitalize":
                $value = Str::title($value);
                break;
        }
    }
    return $value;
}
