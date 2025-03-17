<ul @class(['font-normal space-y-1', 'hidden' => !$menu->expanded,'bg-gray-950/15 dark:bg-gray-950' => $menu->selected]) id="{{ $menu->id }}">
    @foreach($menu->items as $item)
        @php
            $menuLevels = [
                'flex w-full text-sm items-center px-2 py-2 rounded-none hover:bg-gray-400 hover:text-gray-50 dark:hover:bg-gray-900',
                'dark:text-white text-gray-800 bg-gray-100 dark:bg-gray-950' => $item->selected, // Ensure item selection is checked
                'opacity-100 dark:opacity-50' => !$item->selected && $menu->expanded && $item->level > 1,
                'text-gray-700 dark:text-gray-50' => !$item->selected,
                'pl-6' => $item->level === 2,
                'pl-12' => $item->level === 3,
                'pl-18' => $item->level === 4,
            ];
        @endphp
        <li class="mx-0">
            @if($item->hasItems())
                <button type="button" @class($menuLevels) data-collapse-toggle="{{ $item->id }}">
                    @if($item->icon)
                        <span class="">@pixelicon($item->icon)</span>
                    @endif
                    <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ $item->label }}</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="m1 1 4 4 4-4"/>
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
