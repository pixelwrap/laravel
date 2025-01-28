@foreach($nodes as $node)
    @include("pixelwrap::components.node",['node' => $node])
@endforeach
