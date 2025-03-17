@if($button->role === "link")
    <a href="{{$button->link}}" class="{{$button->classes}} flex items-center gap-x-2">
        @if($button->icon)
            @pixelicon($button->icon)
        @endif
        @if($button->showLabel)
            {{ $button->text(get_defined_vars()) }}
        @endif
    </a>
@else
    <button type="{{$button->role}}" class="{{$button->classes}} flex items-center gap-x-2" name="{{$button->name}}" value="{{$button->value}}">
        @if($button->icon)
            @pixelicon($button->icon)
        @endif
        @if($button->showLabel)
            {{ $button->text(get_defined_vars()) }}
        @endif
    </button>
@endif
