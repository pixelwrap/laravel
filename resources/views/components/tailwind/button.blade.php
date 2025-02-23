@if($button->role === "link")
    <a href="{{$button->link}}" class="border border-1 {{$button->classes}}">{{ $button->label }}</a>
@else
    <button type="{{$button->role}}" class="border border-1 {{$button->classes}}" name="action" value="{{$button->value}}">
        {{ $button->label }}
    </button>
@endif
