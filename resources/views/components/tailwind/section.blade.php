@php
    if(!isset($section)){
        raise(null, "You must pass section when rendering the section component");
    }
    if(!isset($section->nodes)){
        $componentError = "Nodes must be set. Please check if your template is formated correctly.";
    }
    [$componentErrors, $border, $margin, $padding] = parseBoxModelProperties($section, get_defined_vars());
@endphp
@if(count($componentErrors) > 0)
    @include("pixelwrap::components/{$theme}/exception",["errors" => $componentErrors, "component" => $row])
@else
    <div class="{{$border}} {{ $margin }} {{$padding}}">
        <div class="grid grid-cols-2 md:grid-cols-2 items-center gap-4">
            <div>
                <h1 class="text-xl font-bold text-gray-800 dark:text-gray-50">{{ interpolateString($section->title,get_defined_vars())}}</h1>
                <p class="text-gray-800 dark:text-gray-50">{{ interpolateString($section->subtitle,get_defined_vars())}}</p>
            </div>
            @isset($section->actions)
                @foreach($section->actions as $action)
                    <div class="flex justify-end space-x-4">
                        @include("pixelwrap::components/{$theme}/button",['button' => $action])
                    </div>
                @endforeach
            @endif
        </div>
        @if(isset($section->nodes))
            @include("pixelwrap::components.nodes",["nodes" => $section->nodes])
        @endif
    </div>
@endif
