<div class="border-b-2 border-gray-300 dark:border-gray-700 {{$tabs->classes}}">
    <ul class="flex flex-wrap text-sm font-medium text-center"
        id="{{$tabs->id}}"
        data-tabs-toggle="#{{$tabs->id}}-content"
        role="tablist"
        data-tabs-active-classes="text-gray-900 border-gray-900 dark:text-gray-100 dark:border-gray-100"
        data-tabs-inactive-classes="text-gray-500 hover:text-gray-600 dark:text-gray-400 border-transparent hover:border-gray-300 dark:hover:text-gray-300">
        @foreach($tabs->tabs as $tab)
            <li class="mr-2" role="presentation">
                <a href="#{{$tab->id}}"
                   class="inline-flex items-center px-4 py-3 border-b-2 border-transparent rounded-t-lg transition-all duration-200 ease-in-out group
                          hover:text-gray-600 hover:border-gray-300
                          dark:hover:text-gray-300"
                   id="{{$tab->id}}-tab"
                   data-tabs-target="#{{$tab->id}}"
                   type="button"
                   role="tab">
                    @if($tab->icon)
                        <span class="mr-2">@pixelicon($tab->icon)</span>
                    @endif
                    <span class="font-semibold">{{ $tab->text(get_defined_vars()) }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>

<div id="{{$tabs->id}}-content">
    @foreach($tabs->tabs as $tab)
        <div class="hidden"
             id="{{$tab->id}}"
             role="tabpanel"
             aria-labelledby="{{$tab->id}}-tab">
            {{ $tab->render(get_defined_vars()) }}
        </div>
    @endforeach
</div>
