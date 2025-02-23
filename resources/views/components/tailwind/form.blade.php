<form action="{{$form->action}}" method="{{ $form->method === 'get' ? 'get' : 'post' }}" autocomplete="{{ $form->autocomplete === true ? "on" : "off" }}">
    @method($form->method)
    @csrf
    @foreach($form->nodes as $component)
        {{ $component->render() }}
    @endforeach
</form>
