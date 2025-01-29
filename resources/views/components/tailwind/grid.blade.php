@php
    if(!isset($grid)){
        raise(null, "You must pass \"grid\" when rendering the grid component");
    }
    if(!isset($grid->nodes)){
        $gridErrors = ["Nodes must be set. Please check if your template is formated correctly."];
    }else{
        $columns = $columnOptions[$grid->cols ?? 12];
        [$gridErrors, $border, $margin, $padding, $gap] = parseBoxModelProperties($grid, get_defined_vars());
    }
@endphp
@if(count($gridErrors)>0)
    @include("pixelwrap::components/{$theme}/exception",["errors" => $gridErrors, "component" => $grid])
@else
    <div class="grid {{$columns}} {{$border}} {{ $margin }} {{$padding}} {{ $gap }} align-top">
        @foreach($grid->nodes as $node)
            <div class="{{$colSpanOptions[$node->span ?? 3]}}">
                @include("pixelwrap::components.node",["node" => $node])
            </div>
        @endforeach
    </div>
@endif
