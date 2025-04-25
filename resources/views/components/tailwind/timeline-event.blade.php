<li class="mb-0 ms-4 relative">
    @if($timeline->orientation === "horizontal")
        <div class="flex items-center">
            <div
                class="{{$timeline->iconSizeClasses}} z-10 flex items-center justify-center  text-blue-800 dark:text-blue-300 bg-blue-100 rounded-full ring-0 ring-white dark:bg-blue-900 sm:ring-2 dark:ring-gray-900 shrink-0">
                @if($event->node->icon ?? false)
                    @pixelicon(interpolateString($event->node->icon, get_defined_vars()))
                @endif
            </div>
            <div class="hidden sm:flex w-full bg-gray-200 h-0.5 dark:bg-gray-700"></div>
        </div>
    @else
        @if($event->node->icon ?? false)
            <span
                class="absolute flex items-center justify-center {{$timeline->iconSizeClasses}} bg-blue-100 text-blue-800 dark:text-blue-300 rounded-full ring-4 ring-white dark:ring-gray-900 dark:bg-blue-900">
                       @pixelicon(interpolateString($event->node->icon, get_defined_vars()))
            </span>
        @else
            <span
                class="absolute {{$timeline->iconSizeClasses}} bg-gray-200 rounded-full mt-2 ring-4 text-blue-800 dark:text-blue-300  border border-white dark:border-gray-50 dark:bg-gray-700"></span>
        @endif
    @endif

    <div @class(["m-0 mt-2 flex-grow-1" => $timeline->orientation === "horizontal", "ms-4" => $timeline->orientation === "vertical"])>
        {{ $event->render(get_defined_vars()) }}
    </div>
</li>
