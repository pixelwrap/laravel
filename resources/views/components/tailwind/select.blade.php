<div class="relative z-0 w-full group">
    <label for="{{$select->id}}" class="{{$select->labelClasses}}">{{ $select->label }}</label>
    <div class="relative">
        <select id="{{$select->id}}" name="{{ $select->id }}" class="{{$select->classes}}" @required($select->required)>
            @if($select->placeholder)
                <option value="">{{ $select->placeholder}}</option>
            @endif
            @foreach($select->options as $option => $label)
                <option value="{{$option}}" @selected($select->value == $option)>{{ $label }}</option>
            @endforeach
        </select>
        <svg fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="{{$select->caretClasses}}">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"/>
        </svg>
    </div>
</div>
