<div class="grid align-top {{$grid->classes}}">
    @foreach($grid->nodes as $component)
        <div class="{{$node->span ?? 3}}">
            {{ $component->render() }}
        </div>
    @endforeach
</div>
