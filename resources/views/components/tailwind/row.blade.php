<div class="flex {{ $row->classes }}">
    @foreach($row->nodes as $component)
        {{ $component->render(get_defined_vars()) }}
    @endforeach
</div>
