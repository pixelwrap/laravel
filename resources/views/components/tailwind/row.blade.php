<div class="flex {{ $row->classes }}">
    @foreach($row->nodes as $component)
        {{ $component->render() }}
    @endforeach
</div>
