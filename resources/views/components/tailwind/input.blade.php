@php
    if(!isset($input)){
      raise(null, "You must pass input when rendering the input component");
    }

    $inputErrors    = [];
    $floatLabelClass =  "peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6";
    $floatInputClass =  "block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-500 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer";
    $labelType2Class =  "block my-1 text-sm font-medium text-gray-800 dark:text-gray-50";
    $inputType2Class =  "w-full px-4 py-2 text-sm text-gray-900 bg-white border border-gray-600 rounded-sm shadow-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 focus:outline-none";

    if(($input->class ?? "float") === "default") {
        $labelClass = $floatLabelClass;
        $inputClass = $floatInputClass;
    }else{
        $labelClass = $labelType2Class;
        $inputClass = $inputType2Class;
    }

    if($input->disabled ?? false){
        $inputClass = sprintf("%s %s", $inputClass, "disabled:opacity-50 cursor-not-allowed bg-gray-100");
    }

    $props = filterAndMapObjectProps($input, ['id', 'name', 'label', 'fieldType', 'type', 'required', 'action']);

    $inputId        = $input->id;
    $inputValue     = old($inputId, $$inputId ?? "");
    $inputType      = $input->type ?? "text";
    $inputRequired  = $input->required ?? false;
    $showLabel      = $input->showLabel ?? true;

    if($showLabel && !isset($input->label)){
        $inputErrors[] = "Label must be set. Please check if your template is compliant with the specification.";
    }
@endphp

@if(count($inputErrors)>0)
    @include("pixelwrap::components/{$theme}/exception",["errors" => $inputErrors, "component" => $input])
@else
    @if($inputType === "hidden")
        <input type="hidden" name="{{$inputId }}" id="{{$inputId}}" value="{{$currentValue}}">
    @else
        {{-- For Float input label comes last, otherwise first. --}}
        @if($floatInputClass === $inputClass)
            <div class="relative z-0 w-full group">
                <input id="{{$inputId}}" type="{{$inputType}}" name="{{ $inputId }}" value="{{ $inputValue }}"
                       placeholder=" " class="{{$inputClass}}" @required($inputRequired) {{$props}}/>
                <label for="{{$inputId}}" class="{{$labelClass}}">{{ $input->label }}</label>
            </div>
        @else
            <div class="relative z-0 w-full group">
                @if($showLabel)
                    <label for="{{$inputId}}" class="{{$labelClass}}">{{$input->label}}</label>
                @endif
                <input id="{{$inputId}}" type="{{$inputType}}" name="{{$inputId}}" value="{{$inputValue}}"
                       class="{{$inputClass}}" @required($inputRequired) {!! $props !!}/>
            </div>
        @endif
    @endif
@endif

