<div class="grid {{$column->classes}} align-left">
    @foreach($column->nodes as $component)
        {{ $component->render() }}
    @endforeach
</div>
