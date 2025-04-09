<div class="flex flex-column {{ $tab->classes }}">
    @foreach($tab->nodes as $component)
        {{ $component->render(get_defined_vars()) }}
    @endforeach
</div>
