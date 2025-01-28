@php
    if(!isset($select)){
      raise(null, "You must pass select when rendering the select component");
    }
    $labelClass     =  "block my-1 text-sm font-medium text-gray-800 dark:text-gray-50";
    $selectClass    =  "w-full bg-transparent text-gray-700 dark:text-gray-200 text-sm border border-gray-600 dark:border-gray-400 rounded-sm pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-gray-400 dark:focus:border-gray-300 hover:border-gray-400 dark:hover:border-gray-300 shadow-sm focus:shadow-md appearance-none cursor-pointer dark:bg-gray-800";
    $caretClass     =  "h-5 w-5 ml-1 absolute top-2.5 right-2.5 text-slate-700 dark:text-gray-300";

    if($select->disabled ?? false){
      $selectClass  = sprintf("%s %s", $selectClass, "disabled:opacity-50 cursor-not-allowed bg-gray-100");
    }

    $inputId        = $select->id;
    $currentValue   = old($inputId, $$inputId ?? "");
    $inputRequired  = $input->required ?? false;
@endphp

<label for="{{$inputId}}" class="{{$labelClass}}">{{ $select->label }}</label>

<div class="relative">
    <select id="{{$inputId}}" name="{{ $inputId }}" class="{{$selectClass}}" @required($inputRequired)>
        @foreach($select->options as $option => $label)
            <option value="{{$option}}" @selected($currentValue == $option)>{{ $label }}</option>
        @endforeach
    </select>
    <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="{{$caretClass}}">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"/>
    </svg>
</div>

