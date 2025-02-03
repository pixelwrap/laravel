<div class="flex items-center {{ $row->classes }}">
    @foreach($row->nodes as $component)
        {{ $component->render() }}
    @endforeach
</div>
