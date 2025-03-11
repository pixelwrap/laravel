<div class="relative z-0 w-full group">
    <label for="{{$select->id}}" class="{{$select->labelClasses}}">{{ $select->text(get_defined_vars()) }}</label>
    <div class="relative">
        <select id="{{$select->id}}" name="{{ $select->id }}" class="{{$select->classes}}" @required($select->required) @disabled($select->disabled)>
            @if($select->placeholder)
                <option value="">{{ $select->placeholder}}</option>
            @endif
            @foreach($select->options as $option => $label)
                <option value="{{$option}}" @selected($select->value == $option)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>
