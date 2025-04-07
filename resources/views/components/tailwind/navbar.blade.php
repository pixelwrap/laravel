<nav class="bg-gray-300 dark:bg-gray-900 print:hidden {{ $navbar->classes }}">
    <div class="relative flex h-auto items-center justify-between">
        <div class="flex flex-1 sm:items-stretch sm:justify-start">
            <div class="hidden sm:block">
                <div class="flex space-x-1">
                    @foreach($navbar->menu->items as $item)
                        <a href="{{ $item->link }}"
                            @class([
                               'px-2 py-2 text-sm font-bold flex flex-row gap-x-2 items-center border-b-4 ',
                               'text-gray-900 border-gray-900 dark:border-gray-50 dark:text-gray-50 hover:text-white dark:hover:text-gray-50 dark:hover:bg-gray-950 hover:bg-gray-600' => $item->selected,
                               'text-gray-950 dark:bg-gray-900 dark:border-gray-900 hover:border-gray-200 dark:hover:border-gray-800 border-gray-100 dark:text-gray-300 hover:text-white dark:hover:text-gray-950 dark:hover:bg-gray-200 hover:bg-gray-950' => !$item->selected])>
                            @if($item->icon)
                                <span>@pixelicon($item->icon)</span>
                            @endif
                            {{ $item->label }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="inset-y-0 left-0 flex items-center sm:hidden">
            <button data-drawer-target="{{$navbar->id}}" data-drawer-toggle="{{$navbar->id}}" type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 {{ $navbar->classes }}">
                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                          d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
                </svg>
            </button>
        </div>
    </div>
    <div class="hidden" id="{{$navbar->id}}">
        <div class="space-y-1 px-2 pb-3 pt-2">
            @foreach($navbar->menu->items as $item)
                <a href="{{ $item->link }}"
                    @class([
                       'block px-3 py-2 text-sm font-medium',
                       'bg-gray-800 text-gray-50 dark:bg-gray-50 dark:text-gray-950' => $item->selected,
                       'bg-gray-300 text-gray-950 dark:bg-gray-900 dark:text-gray-50' =>!$item->selected ])>
                    {{ $item->label }}
                </a>
            @endforeach
        </div>
    </div>
</nav>
