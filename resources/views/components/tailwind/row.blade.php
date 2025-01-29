@php
    if(!isset($row)){
        raise(null, "You must pass row when rendering the row component");
    }
    if(!isset($row->nodes)){
        $rowErrors = ["Nodes must be set. Please check if your template is formated correctly."];
    }else{
        [$rowErrors, $border, $margin, $padding, $gap] = parseBoxModelProperties($row, get_defined_vars());
    }
@endphp
@if(count($rowErrors) > 0)
    @include("pixelwrap::components/{$theme}/exception",["errors" => $rowErrors, "component" => $row])
@else
    <div class="flex items-end {{$border}} {{ $margin }} {{$padding}} {{ $gap }}">
        @include("pixelwrap::components.nodes",["nodes" => $row->nodes])
    </div>
@endif
