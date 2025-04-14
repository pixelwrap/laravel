<div class="flex flex-col flex-grow h-full w-full {{ $view->classes }}">
    {!! view($view->view, get_defined_vars()) !!}
</div>
