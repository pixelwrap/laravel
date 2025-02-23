<div class="grid align-bottom items-end  {{$grid->classes}}">
    @foreach($grid->nodes as $component)
        <div class="{{$component->spanClasses}}">
            {{ $component->render() }}
        </div>
    @endforeach
</div>
