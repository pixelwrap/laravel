@php
    if(!isset($heading)){
        raise(null, "You must pass heading when rendering the heading component");
    }

    $headingTypes = [
        "biggest"   => "text-5xl",
        "bigger"    => "text-4xl",
        "big"       => "text-3xl",
        "small"     => "text-2xl",
        "smaller"   => "text-xl",
        "smallest"  => "text-md"
    ];

    $keys   =   array_keys($headingTypes);
    $size   =   mb_strtolower($heading->size ?? 'small');
    if(!in_array($size, $keys)){
        $headingErrors = [sprintf("Heading \"size\" must be one of %s. ", implode(", ", $keys))];
    }else{
        $headingErrors = [];
    }
    [$componentErrors, $border, $margin, $padding] = parseBoxModelProperties($heading, get_defined_vars());
    $headingErrors = array_merge($componentErrors, $headingErrors)
@endphp
@if(count($headingErrors) > 0)
    @include("pixelwrap::components/{$theme}/exception",["errors" => $headingErrors, "component" => $heading])
@else
    <h2 class="{{$headingTypes[$size]}} font-bold text-gray-800 dark:text-gray-50 {{$border}} {{ $margin }} {{$padding}}">{{ interpolateString($heading->label,get_defined_vars())}}</h2>
@endif
