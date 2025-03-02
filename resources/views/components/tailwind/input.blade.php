<div class="relative z-0 w-full group">
    @if($input->showLabel)
        <label for="{{$input->id}}" class="{{$input->labelClasses}}">
            {{$input->text(get_defined_vars())}}
        </label>
    @endif
    <input @disabled($input->disabled) type="{{$input->fieldType}}" placeholder="{{$input->placeholder}}" class="{{$input->classes}}" @required($input->required) value="{{$input->value}}" name="{{$input->name}}" autocomplete="{{ $input->autocomplete === true ? "on" : "new-password" }}" id="{{$input->id}}"/>
</div>
