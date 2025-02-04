@php
    $labelClass =  "block my-1 text-sm font-medium text-gray-800 dark:text-gray-50";
    $inputClass =  "w-full px-4 py-2 text-sm text-gray-900 bg-white border border-gray-600 rounded-sm shadow-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 focus:outline-none";

    if($input->disabled ?? false){
        $inputClass = sprintf("%s %s", $inputClass, "bg-gray-50 dark:bg-gray-400 disabled:opacity:50 cursor-not-allowed");
    }
@endphp

<div class="relative z-0 w-full group">
    @if($input->showLabel)
        <label for="{{$input->id}}" class="{{$labelClass}}">{{$input->label}}</label>
    @endif
    <input id="{{$input->id}}" type="{{$input->fieldType}}" name="{{$input->id}}" value="{{$input->value}}"
           class="{{$inputClass}}" @required($input->required)
           autocomplete="{{ $input->autocomplete === true ? "on" : "off" }}"/>
</div>
