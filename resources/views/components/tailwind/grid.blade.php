<div class="grid {{$grid->classes}}">
    @foreach($grid->nodes as $component)
        @php
            $rendered = $component->render(get_defined_vars());
        @endphp
        @if($rendered)
        <div class="{{$component->spanClasses}}">
            {{$rendered}}
        </div>
        @endif
    @endforeach
</div>
