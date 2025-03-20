<div class="relative type-ahead">
    {{ $typeahead->input->render(get_defined_vars()) }}
    <div
        class="absolute z-10 hidden w-full mt-1 bg-white border border-gray-300 rounded-sm shadow-lg dark:bg-gray-800 dark:border-gray-900 type-ahead-results">
        <ul class="divide-y divide-gray-200 dark:divide-gray-950/20"></ul>
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
            "{{$typeahead->image}}",
            "{{$typeahead->show}}",
            "{{$typeahead->attach}}",
            "{!!$typeahead->input->value ?? ''!!}",
            "{{$typeahead->value ?? ''}}"
        )
    });
</script>
