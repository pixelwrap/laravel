<?php

use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Support\Collection;
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
                return ''; // Return an empty string if not found
            }
        }

        return $value; // Return the resolved value
    }, $format);
}


function filter($filters, $value): string | null
{
    foreach ($filters as $rawFilter) {
        if(Str::contains($rawFilter, ':')) {
            [$filter, $params] = explode(':', $rawFilter);
            $params = explode(',', $params);
        }else{
            $filter = $rawFilter;
            $params = [];
        }
        switch ($filter) {
            case 'bool':
            case 'boolean':
                $params = [...$params, 'False', 'True'];
                $value  = $params[$value];
                break;
            case 'number':
                $value = number_format(floatval($value),2);
                break;
            case 'lowercase':
                $value = Str::lower($value);
                break;
            case 'uppercase':
                $value = Str::upper($value);
                break;
            case 'capitalize':
                $value = Str::title($value);
                break;
        }
    }
    return $value;
}

