@php
    if(!isset($nodes)){
        raise(null, "You must pass nodes when rendering the nodes component");
    }
@endphp
@foreach($nodes as $node)
    @include("pixelwrap::components.node",['node' => $node])
@endforeach
