@php
    if(!isset($row)){
        raise(null, "You must pass row when rendering the row component");
    }
    if(!isset($row->nodes)){
        $componentError = "Nodes must be set. Please check if your template is formated correctly.";
    }
    [$componentErrors, $border, $margin, $padding, $gap] = parseBoxModelProperties($row, get_defined_vars());
@endphp
@if(count($componentErrors) > 0)
    @include("vortex::components/{$theme}/exception",["errors" => $componentErrors, "component" => $row])
@else
    <div class="flex items-center {{$border}} {{ $margin }} {{$padding}} {{ $gap }}">
        @include("vortex::components.nodes",["nodes" => $row->nodes])
    </div>
@endif
