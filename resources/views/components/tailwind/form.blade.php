<form action="{{$form->action}}" method="{{ $form->method === 'get' ? 'get' : 'post' }}">
    @method($form->method)
    @csrf
    @foreach($form->nodes as $component)
        {{ $component->render() }}
    @endforeach
</form>
