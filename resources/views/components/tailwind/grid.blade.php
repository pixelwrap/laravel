@php
    if(!isset($grid)){
        raise(null, "You must pass \"grid\" when rendering the grid component");
    }
    $gridErrors = [];
    if(!isset($grid->nodes)){
        $gridErrors[] = "Nodes must be set. Please check if your template is formated correctly.";
    }else{
        $columns = $grid->cols ?? 12;
        $validations= [
            "columns" => array_keys($columnOptions)
        ];

        foreach($grid->nodes as $index => $node) {
            $validations["Grid Node:" . $index] = range(1,12);
        }
        foreach ($validations as $key => $options){
            if(!in_array($$key, $options)){
                $buttonErrors[] = sprintf("\"%s\" only allows one of %s.", mb_ucfirst($key) , implode(", ", $options));
            }
        }

        [$gridErrors, $border, $margin, $padding, $gap] = parseBoxModelProperties($grid, get_defined_vars());
    }

    if(count($gridErrors) ===0 ){
        $columns = $columnOptions[$columns];
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
