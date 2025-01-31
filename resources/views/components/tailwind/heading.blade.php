@php
    if(!isset($heading)){
        raise(null, "You must pass heading when rendering the heading component");
    }

    $headingTypes = [
        "biggest"   => "text-4xl",
        "bigger"    => "text-3xl",
        "big"       => "text-2xl",
        "small"     => "text-xl",
        "smaller"   => "text-ld",
        "smallest"  => "text-sm"
    ];

    $keys   =   array_keys($headingTypes);
    $size   =   mb_strtolower($heading->size ?? 'small');
    if(!in_array($size, $keys)){
        $headingErrors = [sprintf("Heading \"size\" must be one of %s. ", implode(", ", $keys))];
    }else{
        [$headingErrors, $border, $margin, $padding] = parseBoxModelProperties($heading, get_defined_vars());
    }
    $size = $headingTypes[$size]
@endphp
@if(count($headingErrors) > 0)
    @include("pixelwrap::components/{$theme}/exception",["errors" => $headingErrors, "component" => $heading])
@else
    <h2 class="{{$size}} {{$border}} {{ $margin }} {{$padding}} p-0 font-bold text-gray-800 dark:text-gray-50">
        {{ interpolateString($heading->label,get_defined_vars())}}
    </h2>
@endif
