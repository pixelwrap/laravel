<div class="w-full bg-white border border-gray-200 rounded-sm shadow-sm dark:bg-gray-800 dark:border-gray-700">
    @if($card->showTitle)
        <div class="flex items-center justify-between p-2">
            {{ \PixelWrap\Laravel\PixelWrapRenderer::from(get_defined_vars(),['type' => 'heading','label' => $card->text(get_defined_vars())], $card->theme)->render() }}
        </div>
    @endif
    <div class="flow-root px-2 pb-2">
        @foreach($card->nodes as $component)
            {{ $component->render(get_defined_vars()) }}
        @endforeach
    </div>
</div>

