@if($sidebar->showDrawer)
    <button data-drawer-target="{{$sidebar->id}}" data-drawer-toggle="{{$sidebar->id}}" type="button"
            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-sm sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 {{ $sidebar->classes }}">
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
             xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                  d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>
@endif

<aside id="{{$sidebar->id}}"
       class="min-w-64 {{ $sidebar->classes }}">
    <div class="h-full overflow-y-auto bg-gray-100 dark:bg-gray-800 pt-0">
        @include("pixelwrap::components/{$sidebar->theme}/sidebar-item",["menu" => $sidebar->menu])
    </div>
</aside>
