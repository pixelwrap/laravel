@foreach($nodes as $node)
    @include("vortex::components.node",['node' => $node])
@endforeach
