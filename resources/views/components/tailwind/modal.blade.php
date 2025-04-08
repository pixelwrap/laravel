<div id="{{$modal->id(get_defined_vars())}}" data-modal-target="{{$modal->id(get_defined_vars())}}" @if($modal->static) data-modal-backdrop="static" @endif tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-h-full {{$modal->sizeClasses}}">
        <div class="relative bg-gray-200 {{$modal->roundClasses ?? ''}} shadow-sm dark:bg-gray-700">
            <div class="flex items-center justify-between px-4 py-4 md:px-5 md:py-3 border-b dark:border-gray-600 border-gray-300">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex flex-row gap-x-2 items-center">
                    @if($modal->icon)
                        @pixelicon("trash")
                    @endif

                    {{$modal->text(get_defined_vars())}}
                </h3>
                @if($modal->showClose)
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 {{$modal->roundClasses ?? ''}} text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="{{$modal->id(get_defined_vars())}}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                @endif
            </div>
            <div class="flex flex-col flex-grow {{ $modal->classes }}">
                @foreach($modal->nodes as $component)
                    {{ $component->render(get_defined_vars()) }}
                @endforeach
            </div>
            @if($modal->footer)
                <div class="flex flex-row flex-grow border-t border-gray-300 dark:border-gray-600 {{ $modal->footer->classes ?? '' }}">
                    {{ $modal->footer->render(get_defined_vars()) }}
                </div>
            @endif
        </div>
    </div>
</div>
