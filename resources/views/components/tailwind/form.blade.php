@php
    $dataKey = $form->action->route->key ?? null;
    $dataKeyValue = $form->action->route->keyValue ?? $form->action->route->key ?? null;
@endphp
<form
        action="{{ route($form->action->route->name, [...((array) ($form->action->route->params ?? [])), ...($dataKey ? [$dataKey => $$dataKeyValue] : [] )]) }}"
        method="{{ strtolower($form->method) === "get"? 'get' :"post" }}">
    @method($form->method ?? 'post')
    @csrf
    @include("pages::/factory/nodes",['components.nodes' => $form->nodes])
</form>
