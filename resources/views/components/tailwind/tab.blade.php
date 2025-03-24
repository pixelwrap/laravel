<div class="flex flex-row flex-grow {{ $tab->classes }}">
    @foreach($tab->nodes as $component)
        {{ $component->render(get_defined_vars()) }}
    @endforeach
</div>
