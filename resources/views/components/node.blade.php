@php
    $sep = DIRECTORY_SEPARATOR;
    if (isset($node)){
        $file = mb_strtolower($node->type);
    } else{
        raise("\$node is not defined.");
    }
@endphp
@if(file_exists(pixelwrap_resource("components{$sep}{$theme}{$sep}{$file}.blade.php")))
    @include("pixelwrap::components/{$theme}/{$file}",[$file => $node])
@elseif($node->type === "HorizontalRuler")
    @include("pixelwrap::components/{$theme}/hr",['hr' => $node])
@elseif($node->type === null)
    @include("pixelwrap::components/$theme/null",['components.node' => $node])
@else
    @php
        raise("not_implemented", sprintf("Node \"%s\" is not implemented.", mb_ucfirst($node->type)));
    @endphp
@endif
