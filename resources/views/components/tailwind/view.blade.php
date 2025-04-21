<div class="flex flex-col flex-grow h-full w-full {{ $view->classes }}">
    {!! view($view->name, get_defined_vars()) !!}
</div>
