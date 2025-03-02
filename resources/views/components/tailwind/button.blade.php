@if($button->role === "link")
    <a href="{{$button->link}}" class="border border-1 {{$button->classes}}">{{ $button->label }}</a>
@else
    <button type="{{$button->role}}" class="border border-1 {{$button->classes}}" name="{{$button->name}}" value="{{$button->value}}">
        {{ $button->text(get_defined_vars()) }}
    </button>
@endif
