<div class="flex flex-col flex-grow align-left {{$column->classes}}">
    @foreach($column->nodes as $component)
        {{ $component->render(get_defined_vars()) }}
    @endforeach
</div>
