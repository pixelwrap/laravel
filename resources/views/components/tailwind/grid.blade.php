<div class="grid align-bottom items-end  {{$grid->classes}}">
    @foreach($grid->nodes as $component)
        <div class="{{$component->classes}}">
            {{ $component->render() }}
        </div>
    @endforeach
</div>
