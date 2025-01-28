@php
    if(!isset($column)){
        raise(null, "You must pass \"column\" when rendering the column component");
    }
    if(!isset($column->nodes)){
        $componentError = ["Nodes must be set. Please check if your template is formated correctly."];
    }else{
        $componentError = [];
    }

    [$componentErrors, $border, $margin, $padding, $gap] = parseBoxModelProperties($column, get_defined_vars());
    $columnErrors = array_merge($componentErrors, $componentError)

@endphp
@if(count($columnErrors)>0)
    @include("pixelwrap::components/{$theme}/exception",["errors" => $columnErrors, "component" => $column])
@else
    <div class="grid {{$border}} {{ $margin }} {{$padding}} {{ $gap }} align-left">
        @foreach($column->nodes as $node)
            @include("pixelwrap::components.node",["node" => $node])
        @endforeach
    </div>
@endif
