<div class="grid {{$column->classes}} align-left">
    @foreach($column->nodes as $component)
        {{ $component->render(get_defined_vars()) }}
    @endforeach
</div>
