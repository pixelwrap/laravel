@php
    if(!isset($form)){
        raise(null, "You must pass form when rendering the form component");
    }
    if(!isset($form->nodes) || !isset($form->action)|| !isset($form->method)){
        $formErrors = ["Nodes, Action and Method must be set. Please check if your template is formated correctly."];
    }else{
        $method = mb_strtolower($form->method ?? "post");
        [$formErrors, $action] = buildLink($form->action, get_defined_vars());
    }
@endphp
@if(count($formErrors) > 0)
    @include("pixelwrap::components/{$theme}/exception",["errors" => $formErrors, "component" => $form])
@else
    <form action="{{$action}}" method="{{ $method === 'get' ? 'get' : 'post' }}">
        @method($method)
        @csrf
        @include("pixelwrap::components/nodes",['nodes' => $form->nodes])
    </form>
@endif
