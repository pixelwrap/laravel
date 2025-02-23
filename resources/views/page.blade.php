@extends($pageContainer)
@section('pixelwrap-container')
    @foreach($components as $component)
        {{ $component->render() }}
    @endforeach
@endsection
