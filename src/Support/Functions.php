<?php

use Illuminate\Support\Collection;
use Illuminate\View\View;
use League\Uri\BaseUri;
use Symfony\Component\Yaml\Yaml;
use PixelWrap\Laravel\Support\InvalidPropertyValue;
use PixelWrap\Laravel\Support\NodeNotImplemented;
use League\Uri\Http;
use League\Uri\QueryString;

/**
 * @throws Exception
 */
function raise($code, $message)
{
    throw match ($code) {
        "not_implemented"   => new NodeNotImplemented($message, null),
        "invalid"           => new InvalidPropertyValue($message, null),
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

function renderComponentSource($component, $ignoreNodes = true): string
{
    if(is_string($component)) {
        return $component;
    }else{
        if ($ignoreNodes && isset($component->nodes)) {
            $component->nodes = ["section redacted"];
        }
        $data = json_decode(json_encode($component), true);
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

function validateAndParseBoxModel($node, $context, $key, $map): array
{
    $outputs  =  [];
    $options  =  array_keys($context[$map]);
    $value = $node->{$key} ?? 'default';
    if(is_array($value)){
        $value = implode(' ', $value);
    }
    $inputs =  mb_split(" ", mb_strtolower($value));
    $error  =  [];
    foreach ($inputs as $input){
        if(!in_array($input, $options)){
            $error   = sprintf("\"%s\" only allows one of %s.", mb_ucfirst($key) , implode(", ", $options));
        }else{
            $outputs[] = $context[$map][$input];
        }
    }
    return [implode(" ", $outputs), $error];
}

function parseBoxModelProperties($node, $context): array
{
    $spacing = [
        "border"  => "borderOptions",
        "margin"  => "marginOptions",
        "padding" => "paddingOptions",
        "gap"     => "gapOptions"
    ];

    $model    = [];
    $errors   = [];
    foreach ($spacing as $key => $values){
        [$space, $error] = validateAndParseBoxModel($node, $context, $key, $values);
        $model  = array_merge($model, [$space]);
        if($error){
            $errors = array_merge($errors, [$error]);
        }
    }
    return [$errors, ...$model];
}

function buildLink($action, $context): array
{
    $errors = [];
    $link   = $action->link ?? '';
    $link   = BaseUri::from($link);
    if(!$link->isAbsolute()){
       $link = Http::fromBaseUri($link->getUriString(), request()->getUri());
    }
    $query  = Http::fromBaseUri($link)->getQuery();
    $query  = QueryString::parse(mb_strlen($query) >0 ? $query : null);
    if (isset($action->params)) {
        foreach ($action->params as $key => $alias) {
            if (is_object($alias)) {
                if (!isset($alias->key)) {
                    $errors[] = sprintf(
                        "Key field %s must be set. Please check if your template is compliant with the specification.",
                        $action->name
                    );
                }else{
                    $key = $alias->key;
                    $alias  = $alias->alias ?? $key;
                }
            }
            $value  = $context["context"][$key] ?? $context[$key] ?? $key;
            $param  = sprintf("{%s}",$alias);
            if(mb_strpos($link,$param) !== false){
                $link = str_replace($param, $value, $link);
            }else {
                $query[] = [$alias, $value];
            }
        }
    }

    $url = Http::fromBaseUri($link)->withQuery(QueryString::buildFromPairs($query) ?? "");
    return [$errors, $url];
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

