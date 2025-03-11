<div class="grid items-start  {{$grid->classes}}">
    @foreach($grid->nodes as $component)
        <div class="{{$component->spanClasses}}">
            {{ $component->render(get_defined_vars()) }}
        </div>
    @endforeach
</div>
