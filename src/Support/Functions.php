<?php

use Illuminate\Support\Collection;
use Illuminate\View\View;
use Symfony\Component\Yaml\Yaml;
use PixelWrap\Laravel\Support\InvalidValue;
use PixelWrap\Laravel\Support\NodeNotImplemented;

/**
 * @throws Exception
 */
function raise($code, $message)
{
    throw match ($code) {
        "not_implemented"   => new NodeNotImplemented($message, null),
        "invalid"           => new InvalidValue($message, null),
        default             => new Exception($message),
    };
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
    return app('pixelwrap')->render($page, $data);
}

function renderComponentSource($component): string
{
    if(is_string($component)) {
        return $component;
    }else{
        if ($component->ignoreNodes && isset($component->nodes)) {
            $component->nodes = ["section redacted"];
        }
        $data = json_decode(json_encode($component->node), true);
        return Yaml::dump($data, 8, 2, Yaml::DUMP_OBJECT);
    }
}


function interpolateString($format, $variables): string
{
    // Match placeholders like {branch.name}
    return preg_replace_callback('/\{([\w\.]+)\}/', function ($matches) use ($variables) {
        $keys = explode('.', $matches[1]); // Split by dot for nested keys
        $value = $variables;

        // Traverse the object/array hierarchy to resolve the value
        foreach ($keys as $key) {
            if (is_object($value) && isset($value->$key)) {
                $value = $value->$key; // Access object properties
            } elseif (is_array($value) && isset($value[$key])) {
                $value = $value[$key]; // Access array elements
            } else {
                return $matches[0]; // Return the placeholder if not found
            }
        }

        return $value; // Return the resolved value
    }, $format);
}

function filterObjectProps($object,$except): Collection
{
    return collect(get_object_vars($object))
        ->except($except);
}

function filterAndMapObjectProps($object,$except): string
{
    return filterObjectProps($object,$except)
        ->map(fn($value, $key) => $key . '="' . $value . '"')
        ->implode(' ');
}
