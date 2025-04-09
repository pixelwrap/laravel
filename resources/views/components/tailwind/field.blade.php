<div class="flex flex-col">
    <p class="p-0 text-gray-800 dark:text-gray-50 {{$field->classes}} font-bold">
        {{$field->text(get_defined_vars())}}
    </p>
    <p class="p-0 text-gray-800 dark:text-gray-50 text-sm">
        {{$field->value(get_defined_vars())}}
    </p>
</div>
