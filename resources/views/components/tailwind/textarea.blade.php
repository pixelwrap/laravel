<div class="relative z-0 w-full group">
    @if($textarea->showLabel)
        <label for="{{$textarea->id}}" class="{{$textarea->labelClasses}}">
            {{$textarea->text(get_defined_vars())}}
        </label>
    @endif
    <textarea rows="4" @disabled($textarea->disabled)  placeholder="{{$textarea->placeholder}}" class="{{$textarea->classes}}" @required($textarea->required) name="{{$textarea->name}}" id="{{$textarea->id}}">{{$textarea->value}}</textarea>
</div>
