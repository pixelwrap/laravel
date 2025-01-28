@php
    if(!isset($grid)){
        raise(null, "You must pass \"grid\" when rendering the grid-row component");
    }
    if(!isset($grid->nodes)){
        $componentError = "Nodes must be set. Please check if your template is formated correctly.";
    }

    [$componentErrors, $border, $margin, $padding, $gap] = parseBoxModelProperties($grid, get_defined_vars());

@endphp
@if(isset($componentError))
    @include("vortex::components/{$theme}/exception",["error" => $componentError, "component" => $grid])
@else
    <div class="grid {{$border}} {{ $margin }} {{$padding}} {{ $gap }} align-top">
        @foreach($grid->nodes as $node)
            <div class="{{$node->span ?? 'col-span-3'}}">
                @include("vortex::components.node",["node" => $node])
            </div>
        @endforeach
    </div>
@endif
