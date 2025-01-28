@php
    $inputId = $typeahead->id;
    $currentValue = old($inputId, $$inputId ?? "");
    $currentValueLabel = old("$inputId-label", interpolateString($typeahead->value ?? "", get_defined_vars()));
@endphp
<div class="relative">
    <label for="search-input-{{$typeahead->id}}" class="block mb-2 text-sm font-medium text-gray-700">
        {{$typeahead->label}}
    </label>
    <input
        type="text" name="{{ $inputId }}-label"
        value="{{ $currentValueLabel }}"
        placeholder="Start typing..." autocomplete="false"
        class="w-full px-4 py-2 text-sm text-gray-900 bg-white border border-gray-600 rounded-sm shadow-sm focus:ring-1 focus:ring-blue-500 focus:border-blue-500 focus:outline-none"
        id="search-input-{{$typeahead->id}}"
    />
    <div
        class="absolute z-10 hidden w-full mt-1 bg-white border border-gray-300 rounded-sm shadow-lg"
        id="dropdown-results-{{$typeahead->id}}">
        <ul class="divide-y divide-gray-200" id="search-results-{{$typeahead->id}}"></ul>
    </div>
    <input type="hidden" name="{{ $inputId }}" id="{{$inputId}}" value="{{ $currentValue }}"/>
</div>
@section("js")
    @parent
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const valueInput = document.getElementById("{{$inputId}}");
            const searchInput = document.getElementById("search-input-{{$typeahead->id}}");
            const dropdownResults = document.getElementById("dropdown-results-{{$typeahead->id}}");
            const searchResults = document.getElementById("search-results-{{$typeahead->id}}");

            let searchTimeout;
            let results = [];

            // Fetch results dynamically
            const fetchSearchResults = async (query) => {
                searchResults.innerHTML = '<li class="px-4 py-2 text-sm text-gray-500">Loading... </li>';

                try {
                    const response = await fetch(`{{route($typeahead->route)}}?q=${encodeURIComponent(query)}`);
                    results = await response.json();

                    // Clear existing results
                    searchResults.innerHTML = "";

                    if (results.length) {
                        results.forEach((result) => {
                            const li = document.createElement("li");
                            li.className = "px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer";
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
                        searchResults.innerHTML = '<li class="px-4 py-2 text-sm text-gray-500">No results found.</li>';
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
                    dropdownResults.classList.add("hidden");
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
@endsection
