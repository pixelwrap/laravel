<div class="w-full max-w-md bg-white border border-gray-200 rounded-sm shadow-sm dark:bg-gray-800 dark:border-gray-700">
    @if($card->showTitle)
        <div class="flex items-center justify-between p-4">
            <h5 class="text-lg font-bold leading-none text-gray-900 dark:text-white">{{ $card->text(get_defined_vars()) }}</h5>
        </div>
    @endif
    <div class="flow-root px-4 pb-4">
        @foreach($card->nodes as $component)
            {{ $component->render(get_defined_vars()) }}
        @endforeach
    </div>
</div>

