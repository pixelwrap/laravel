@php
    if(!isset($typeahead)){
        raise(null, "You must pass \"typeahead\" when rendering the typeahead component");
    }
    if (!isset($typeahead->id) || !isset($typeahead->action)) {
        $componentError = ["ID and Action must be set. Please check if your template is compliant with the specification."];
    }
    $inputId           = $typeahead->id;
    $query             = $typeahead->query ?? "q";
    $show              = $typeahead->show ?? "name";
    $currentValue      = old($inputId, $$inputId ?? "");
    $typeahead->id     = sprintf("search-input-%s",$inputId);
    $currentValueLabel = old($typeahead->id, interpolateString($typeahead->value ?? "", get_defined_vars()));
    $typeahead->value  = $currentValueLabel;
    $typeahead->autocomplete = "off";

    [$inputErrors, $action] = buildLink($typeahead->action, get_defined_vars());
    $action .= (mb_strpos($action, "?") === false) ? "?" : "&";
@endphp
@if(count($inputErrors)>0)
    @include("pixelwrap::components/{$theme}/exception",["errors" => $inputErrors, "component" => $input])
@else
    <div class="relative">
        @include("pixelwrap::components/{$theme}/input",["input" => $typeahead])
        <div
            class="absolute z-10 hidden w-full mt-1 bg-white border border-gray-300 rounded-sm shadow-lg dark:bg-gray-700 dark:border-gray-800"
            id="dropdown-results-{{$inputId}}">
            <ul class="divide-y divide-gray-200 dark:divide-gray-600" id="search-results-{{$inputId}}"></ul>
        </div>
        <input type="hidden" name="{{ $inputId }}" id="{{$inputId}}" value="{{ $currentValue }}"/>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const valueInput = document.getElementById("{{$inputId}}");
            const searchInput = document.getElementById("search-input-{{$inputId}}");
            const dropdownResults = document.getElementById("dropdown-results-{{$inputId}}");
            const searchResults = document.getElementById("search-results-{{$inputId}}");

            let searchTimeout;
            let results = [];

            // Fetch results dynamically
            const fetchSearchResults = async (query) => {
                if (results.length === 0) {
                    searchResults.innerHTML = '<li class="px-4 py-2 text-sm text-gray-500 dark:text-gray-50">Loading... </li>';
                }
                try {
                    const response = await fetch(`{!! $action . $query!!}=${encodeURIComponent(query)}`);
                    results = await response.json();
                    if (results.length > 0) {
                        searchResults.innerHTML = "";
                        results.forEach((result) => {
                            const li = document.createElement("li");
                            li.className = "px-4 py-2 text-sm text-gray-700 dark:text-gray-50 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer";
                            li.textContent = result.name; // Assuming the result object has a 'name' field

                            // Add click event to handle user selection
                            li.addEventListener("click", () => {
                                searchInput.value = result.name;
                                valueInput.value = result.{{$typeahead->attach}};
                                dropdownResults.classList.add("hidden");
                            });
                            searchResults.appendChild(li);
                        });
                    } else {
                        // Show "No results found" if no results are returned
                        setTimeout(() => {
                            searchResults.innerHTML = '<li class="px-4 py-2 text-sm text-gray-500 dark:text-gray-50">No results found.</li>';
                        }, 500)
                    }
                } catch (error) {
                    console.error("Error fetching search results:", error);
                    searchResults.innerHTML = '<li class="px-4 py-2 text-sm text-red-500">An error occurred. Please try again. </li>';
                }
            };

            // Handle input changes with debounce
            searchInput.addEventListener("input", (event) => {
                const query = event.target.value.trim();

                // Show dropdown and "Loading..." indicator
                dropdownResults.classList.remove("hidden");

                // Clear existing timeout
                clearTimeout(searchTimeout);

                if (query) {
                    // Add a debounce timer before making the API call
                    searchTimeout = setTimeout(() => fetchSearchResults(query), 100);
                } else {
                    // Hide dropdown if input is empty
                    // dropdownResults.classList.add("hidden");
                    searchResults.innerHTML = "";
                }
            });

            // Hide dropdown when clicking outside the search box
            document.addEventListener("click", (event) => {
                if (!dropdownResults.contains(event.target) && event.target !== searchInput) {
                    dropdownResults.classList.add("hidden");
                }
            });
        });
    </script>
@endif
