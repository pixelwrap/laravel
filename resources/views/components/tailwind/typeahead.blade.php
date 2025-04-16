<div class="relative" data-typeahead-target="{{$typeahead->id}}"
     data-typeahead-action="{{$typeahead->action}}"
     data-typeahead-query="{{$typeahead->query}}"
     data-typeahead-list="{{$typeahead->list}}"
     data-typeahead-image="{{$typeahead->image}}"
     data-typeahead-show="{{$typeahead->show}}"
     data-typeahead-attach="{{$typeahead->attach}}"
     data-typeahead-input-value="{!! $typeahead->input->value ?? '' !!}"
     data-typeahead-value="{{$typeahead->value ?? ''}}">
    {{ $typeahead->input->render(get_defined_vars()) }}
    <div
        class="absolute z-10 hidden w-full mt-1 bg-white border border-gray-300 {{$typeahead->roundModeratedClasses}} shadow-lg dark:bg-gray-800 dark:border-gray-900 type-ahead-results">
        <ul class="divide-y divide-gray-200 dark:divide-gray-950/20"></ul>
        <input type="hidden" name="{{$typeahead->id}}" value="{{$typeahead->value}}"
               id="{{$typeahead->id}}" @required($typeahead->required)/>
    </div>
</div>
