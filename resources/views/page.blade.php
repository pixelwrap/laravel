@php
    if (!isset($theme)){
        $theme = "tailwind";
    }
    require pixelwrap_resource("components/{$theme}/definitions.php");
@endphp
@extends($pixelWrapContainer)
@section('pixelwrap-container')
    @include("pixelwrap::components.nodes",['nodes' => $nodes])
@endsection
