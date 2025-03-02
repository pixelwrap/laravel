@if($button->role === "link")
    <a href="{{$button->link}}" class="{{$button->classes}}">
        @if($button->icon)
            <i class="ti ti-{{ $button->icon }}"></i>
        @endif
        @if($button->showLabel)
            {{ $button->label }}
        @endif
    </a>
@else
    <button type="{{$button->role}}" class="{{$button->classes}}" name="{{$button->name}}" value="{{$button->value}}">
        @if($button->icon)
            <i class="ti ti-{{ $button->icon }}"></i>
        @endif
        @if($button->showLabel)
            {{ $button->text(get_defined_vars()) }}
        @endif
    </button>
@endif
