<div class="relative z-0 w-full group">
    @if($input->showLabel)
        <label for="{{$input->id}}" class="{{$input->labelClasses}}">
            {{$input->text(get_defined_vars())}}
        </label>
    @endif
        @if($input->fieldType === "readonly")
            <p class="w-full py-2 text-sm text-gray-900 dark:text-gray-50">{{ $input->value }}</p>
            <input type="hidden" value="{{$input->value}}" name="{{$input->name}}" id="{{$input->id}} @required($input->required)"/>
        @else
            <div class="relative w-full">
                @if($input->icon)
                    <div class="absolute inset-y-0 start-0 flex items-center ps-2 pointer-events-none">
                        @pixelicon($input->icon)
                    </div>
                @endif
                <input @disabled($input->disabled) type="{{$input->fieldType}}" placeholder="{{$input->placeholder(get_defined_vars())}}" class="{{$input->classes}}" @required($input->required) value="{{$input->value(get_defined_vars())}}" name="{{$input->name}}" autocomplete="{{ $input->autocomplete === true ? "on" : "new-password" }}" id="{{$input->id}}"/>
            </div>
        @endif
</div>
