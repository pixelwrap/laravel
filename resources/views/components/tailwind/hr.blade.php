@php
    if(!isset($hr)){
        raise(null, "You must pass \"hr\" when rendering the horizontal ruler component");
    }
    [$hrErrors, $border, $margin] = parseBoxModelProperties($hr, get_defined_vars());
@endphp
@if(count($hrErrors)>0)
    @include("pixelwrap::components/{$theme}/exception",["errors" => $hrErrors, "component" => $grid])
@else
    <div class="border-b-2 border-gray-300 dark:border-gray-600 w-100  {{$border}} {{ $margin }}"></div>
@endif
