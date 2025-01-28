@php
    $buttonClasses= [
        "primary"   => "text-white bg-blue-700  hover:bg-blue-800 focus:outline-none focus:ring-4  focus:ring-blue-300 font-medium dark:bg-blue-600   dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800",
        "secondary" => "text-white bg-gray-700  hover:bg-gray-900 focus:outline-none focus:ring-4  focus:ring-gray-300 font-medium dark:bg-gray-600   dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700",
        "success"   => "text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-700 dark:border-green-700",
        "danger"    => "text-white bg-red-700   hover:bg-red-800 focus:outline-none focus:ring-4   focus:ring-red-300 font-medium dark:bg-red-600     dark:hover:bg-red-700 dark:focus:ring-red-900 dark:border-red-900",
    ];

    $buttonsSizes = [
        "biggest"   => "text-xl px-6 py-4",
        "bigger"    => "text-lg px-5 py-3",
        "big"       => "test-md px-4 py-2.5",
        "small"     => "text-sm px-3 py-2",
        "smaller"   => "text-sm px-3 py-1.5",
        "smallest"  => "text-xs px-3 py-1"
    ];

    $rounded        =  "rounded-sm";
    $class          =  $button->class ?? 'primary';
    $size           =  $button->size  ?? 'small';
    $role           =  $button->role  ?? 'submit';

    $class   = $buttonClasses[$class];
    $size    = $buttonsSizes[$size];
    $value   = $button->value ?? '';
    $link    = $button->link ?? '';
    $options = ["link","reset","button","submit"];

    if(!in_array($role, $options)){
        $errors = [sprintf("\"%s\" only allows one of %s.", mb_ucfirst("role") , implode(", ", $options))];
    }else{
        $errors = [];
    }

    $buttonErrors = array_merge($errors)
@endphp
@if(count($buttonErrors)>0)
    @include("pixelwrap::components/{$theme}/exception",["errors" => $buttonErrors, "component" => $button])
@else
    @if($role === "link")
        <a href="{{$link}}" class="{{ $class }} {{$rounded}} {{$size}}">{{ $button->label }}</a>
    @else
        <button type="{{$role}}" class="{{$class}} {{$rounded}} {{$size}}" name="action" value="{{$value}}">
            {{ $button->label }}
        </button>
    @endif
@endif
