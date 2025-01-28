@php
    if(!isset($row)){
        raise(null, "You must pass row when rendering the row component");
    }
    if(!isset($row->nodes)){
        $componentError = ["Nodes must be set. Please check if your template is formated correctly."];
    }else{
        $componentError = [];
    }
    [$componentErrors, $border, $margin, $padding, $gap] = parseBoxModelProperties($row, get_defined_vars());
    $rowErrors = array_merge($componentErrors, $componentError)
@endphp
@if(count($rowErrors) > 0)
    @include("pixelwrap::components/{$theme}/exception",["errors" => $rowErrors, "component" => $row])
@else
    <div class="flex items-center {{$border}} {{ $margin }} {{$padding}} {{ $gap }}">
        @include("pixelwrap::components.nodes",["nodes" => $row->nodes])
    </div>
@endif
