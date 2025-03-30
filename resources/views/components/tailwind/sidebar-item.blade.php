<ul @class([
    'font-normal space-y-1 transition-all duration-300 ease-in-out',
    'hidden' => !$menu->expanded,
    'bg-gray-300 dark:bg-gray-900' => $menu->selected, // Adjusted base colors
]) id="{{ $menu->id }}">
    @foreach($menu->items as $item)
        @php
            $menuLevels = [
                'flex w-full text-sm items-center px-2 py-2 rounded-none hover:bg-gray-200 dark:hover:bg-gray-800 transition-all duration-700 ease-in-out active:scale-95 active:bg-gray-300 dark:active:bg-gray-700', // Adjusted active states
                'text-white dark:text-gray-100 bg-gray-400 dark:bg-gray-950' => $item->selected, // Better contrast for selected
                'opacity-75 dark:opacity-60' => !$item->selected && $menu->expanded && $item->level > 1, // Softer opacity
                'text-gray-900 dark:text-gray-200' => !$item->selected, // Better non-selected contrast
                'pl-6'  => $item->level === 2,
                'pl-12' => $item->level === 3,
                'pl-18' => $item->level === 4,
            ];
        @endphp
        <li class="mx-0">
            @if($item->hasItems())
                <button type="button" @class($menuLevels) data-collapse-toggle="{{$item->id}}"
                       aria-expanded={{$item->expanded ? "true": "false"}}>
                    @if($item->icon)
                        <span>@pixelicon($item->icon)</span>
                    @endif
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ $item->label }}</span>
                    <svg class="w-3 h-3 transition-transform duration-300 ease-in-out chevron {{ $item->expanded ? 'rotate-180' : '' }}"
                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                @include("pixelwrap::components/{$item->theme}/sidebar-item", ["menu" => $item])
            @else
                <a href="{{ $item->link }}" @class($menuLevels)>
                    @if($item->icon)
                        <span>@pixelicon($item->icon)</span>
                    @endif
                    <span class="ms-3">{{ $item->label }}</span>
                </a>
            @endif
        </li>
    @endforeach
</ul>
