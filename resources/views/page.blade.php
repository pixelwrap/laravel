@php
    if (!isset($theme)){
        $theme = "tailwind";
    }
    require vortex_resource("components/{$theme}/definitions.php");
@endphp
@extends($vortexContainer)
@section('vortex-container')
    @include("vortex::components.nodes",['nodes' => $nodes])
@endsection
