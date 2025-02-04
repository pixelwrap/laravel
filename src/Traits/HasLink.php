<?php

namespace PixelWrap\Laravel\Traits;

use League\Uri\BaseUri;
use League\Uri\Http;
use League\Uri\QueryString;

trait HasLink
{
    public function buildLink($context): string
    {
        $action = $this->node->action;
        $link   = $action->link;
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
                        $this->errors[] = sprintf(
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
                $decodedLink = urldecode($link);
                if(mb_strpos($decodedLink, $param) !== false){
                    $link = str_replace($param, $value, $decodedLink);
                }else {
                    $query[] = [$alias, $value];
                }
            }
        }
        return Http::fromBaseUri($link)->withQuery(QueryString::buildFromPairs($query) ?? "");
    }

}
