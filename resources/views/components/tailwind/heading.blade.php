<h2 class="p-0 font-normal text-gray-800 flex items-center justify-between dark:text-gray-50 {{$heading->classes}}">
    <span> {{$heading->text(get_defined_vars())}} </span>
    <div class="flex items-center justify-end gap-x-2">
        @foreach($heading->actions as $action)
            {{$action->render(get_defined_vars())}}
        @endforeach
    </div>
</h2>
