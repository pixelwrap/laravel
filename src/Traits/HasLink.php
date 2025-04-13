<?php

namespace PixelWrap\Laravel\Traits;

use League\Uri\BaseUri;
use League\Uri\Http;
use League\Uri\QueryString;

trait HasLink
{
    public function buildLink($action, $context): string
    {
        $link   = is_string($action) ? $action : $action->link;
        $link   = BaseUri::from($link);
        $link   = Http::fromBaseUri($link->getUriString(), request()->getUri());
        $link   = $link->withPath(rtrim($link->getPath(), '/'));
        $query  = Http::fromBaseUri($link)->getQuery();
        $query  = QueryString::parse(mb_strlen($query) >0 ? $query : null);
        if (isset($action->params)) {
            foreach ($action->params as $key => $value) {
                if (is_object($value)) {
                    if (!isset($value->key)) {
                        $this->errors[] = sprintf(
                            "Key field %s must be set. Please check if your template is compliant with the specification.",
                            $action->name
                        );
                    }else{
                        $key    = $value->key;
                        $value  = $value->alias ?? $value->value ?? $key;
                    }
                }

                $param  =  sprintf("{%s}", $key);
                if(isset($context[$value])){
                    $value  =  $context[$value];
                }
                $decodedLink = urldecode($link);
                if(mb_strpos($decodedLink, $param) !== false){
                    $link = str_replace($param, $value, $decodedLink);
                }else {
                    $query[] = [$key, $value];
                }
            }
        }
        $link = urldecode($link);
        $link = interpolateString($link, $context);
        return Http::fromBaseUri($link)->withQuery(QueryString::buildFromPairs($query) ?? "");
    }

}
