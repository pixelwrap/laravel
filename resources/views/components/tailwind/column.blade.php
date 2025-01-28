@php
    if(!isset($column)){
        raise(null, "You must pass \"column\" when rendering the column component");
    }
    if(!isset($column->nodes)){
        $componentError = "Nodes must be set. Please check if your template is formated correctly.";
    }

    [$componentErrors, $border, $margin, $padding, $gap] = parseBoxModelProperties($column, get_defined_vars());

@endphp
@if(isset($componentError))
    @include("vortex::components/{$theme}/exception",["error" => $componentError, "component" => $column])
@else
    <div class="grid {{$border}} {{ $margin }} {{$padding}} {{ $gap }} align-left">
        @foreach($column->nodes as $node)
            @include("vortex::components.node",["node" => $node])
        @endforeach
    </div>
@endif
