<div class="relative type-ahead">
    {{ $typeahead->input->render(get_defined_vars()) }}
    <div
        class="absolute z-10 hidden w-full mt-1 bg-white border border-gray-300 rounded-sm shadow-lg dark:bg-gray-700 dark:border-gray-800 type-ahead-results">
        <ul class="divide-y divide-gray-200 dark:divide-gray-600"></ul>
        <input type="hidden" name="{{$typeahead->id}}" value="{{$typeahead->value}}" id="{{$typeahead->id}}" @required($typeahead->required)/>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        setupTypeAhead(
            "{{$typeahead->id}}",
            "{{$typeahead->action}}",
            "{{$typeahead->query}}",
            "{{$typeahead->list}}",
            "{{$typeahead->show}}",
            "{{$typeahead->attach}}",
            "{!!$typeahead->input->value ?? ''!!}",
            "{{$typeahead->value ?? ''}}"
        )
    });
</script>
