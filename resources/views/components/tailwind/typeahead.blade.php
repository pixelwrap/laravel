<div class="relative">
    {{ $typeahead->input->render() }}
    <div
        class="absolute z-10 hidden w-full mt-1 bg-white border border-gray-300 rounded-sm shadow-lg dark:bg-gray-700 dark:border-gray-800"
        id="autocomplete-dropdown-results-{{$typeahead->id}}">
        <ul class="divide-y divide-gray-200 dark:divide-gray-600" id="autocomplete-results-{{$typeahead->id}}"></ul>
    </div>
    <input type="hidden" name="{{$typeahead->id}}" id="{{$typeahead->id}}" value="{{$typeahead->value}}"/>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const valueInput = document.getElementById("{{$typeahead->id}}");
        const searchInput = document.getElementById("autocomplete-input-{{$typeahead->id}}");
        const dropdownResults = document.getElementById("autocomplete-dropdown-results-{{$typeahead->id}}");
        const searchResults = document.getElementById("autocomplete-results-{{$typeahead->id}}");

        let searchTimeout;
        let results = [];

        // Fetch results dynamically
        const fetchSearchResults = async (query) => {
            if (results.length === 0) {
                searchResults.innerHTML = '<li class="px-4 py-2 text-sm text-gray-500 dark:text-gray-50">Loading... </li>';
            }
            try {
                const response = await fetch(`{!! $typeahead->action . $typeahead->query!!}=${encodeURIComponent(query)}`);
                results = await response.json();
                if (results.length > 0) {
                    searchResults.innerHTML = "";
                    results.forEach((result) => {
                        const li = document.createElement("li");
                        li.className    = "px-4 py-2 text-sm text-gray-700 dark:text-gray-50 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer";
                        li.textContent  = result.{{$typeahead->list}};

                        // Add click event to handle user selection
                        li.addEventListener("click", () => {
                            searchInput.value = result.{{$typeahead->show}};
                            valueInput.value  = result.{{$typeahead->attach}};
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
                searchResults.innerHTML = '<li class="px-4 py-2 text-sm text-gray-500 text-red-500">An error occurred. Please try again. </li>';
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
