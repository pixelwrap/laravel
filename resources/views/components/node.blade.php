@php
    $sep = DIRECTORY_SEPARATOR;
    if (isset($node)){
        $file = mb_strtolower($node->type);
    } else{
        raise("\$node is not defined.");
    }
@endphp
@if(file_exists(vortex_resource("components{$sep}{$theme}{$sep}{$file}.blade.php")))
    @include("vortex::components/{$theme}/{$file}",[$file => $node])
@elseif($node->type === "HorizontalRuler")
    @include("vortex::components/$theme}/hr",['ruler' => $node])
@elseif($node->type === null)
    @include("vortex::components/$theme/null",['components.node' => $node])
@else
    @php
        raise("not_implemented", sprintf("Node \"%s\" is not implemented.", mb_ucfirst($node->type)));
    @endphp
@endif
