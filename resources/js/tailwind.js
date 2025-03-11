// On page load or when changing themes, best to add inline in `head` to avoid FOUC
if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
    document.documentElement.classList.add('dark');
} else {
    document.documentElement.classList.remove('dark')
}

function setupTypeAhead(searchInputId, endPoint, queryName, list, show, attach, label, value) {
    const valueInput    = document.getElementById(searchInputId);
    const searchInput   = valueInput.closest('.type-ahead').querySelector("input");
    const resultsWindow = valueInput.closest(".type-ahead").querySelector(".type-ahead-results");
    const results       = resultsWindow.querySelector("ul");
    const url           = new URL(endPoint);
    let currentWorkId   = 0;
    let searchTimeout;
    let currentValue = value;
    let currentLabel = label;

    // Fetch results dynamically
    const fetchSearchResults = async (query, workId) => {
        url.searchParams.set(queryName, query);
        try {
            const response = await fetch(url).then(res => res.json());
            if(workId >= currentWorkId ){
                if (response.length > 0) {
                    results.innerHTML = "";
                    response.forEach((result) => {
                        const li = document.createElement("li");
                        li.className = "px-4 py-2 text-sm text-gray-700 dark:text-gray-50 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer";
                        li.textContent = result[list];

                        // Add click event to handle user selection
                        li.addEventListener("click", () => {
                            searchInput.value = result[show];
                            valueInput.value  = result[attach];
                            currentLabel      = searchInput.value;
                            currentValue      = valueInput.value;
                            resultsWindow.classList.add("hidden");
                        });
                        results.appendChild(li);
                    });
                } else {
                    // Show "No results found" if no results are returned
                    setTimeout(() => {
                        results.innerHTML = '<li class="px-4 py-2 text-sm text-gray-500 dark:text-gray-50">No results found.</li>';
                    }, 500)
                }
            }
        } catch (error) {
            console.error("Error fetching search results:", error);
            results.innerHTML = '<li class="px-4 py-2 text-sm text-gray-500 text-red-500">An error occurred. Please try again. </li>';
        }
    };

    // Handle input changes with debounce
    searchInput.addEventListener("input", (event) => {
        const query = event.target.value.trim();

        // Show dropdown and "Loading..." indicator
        resultsWindow.classList.remove("hidden");
        results.innerHTML = '<li class="px-4 py-2 text-sm text-gray-500 dark:text-gray-50">Loading... </li>';

        // Clear existing timeout
        clearTimeout(searchTimeout);
        currentWorkId++;
        if (query) {
            // Add a debounce timer before making the API call
            searchTimeout = setTimeout(() => fetchSearchResults(query, currentWorkId), 100);
        } else {
            // Hide dropdown if input is empty
            results.innerHTML = "";
        }
    });

    document.addEventListener("click", (event) => {
        // Hide dropdown when clicking outside the search box and reset input value
        if (!resultsWindow.classList.contains("hidden") && !resultsWindow.contains(event.target) && event.target !== searchInput) {
            resultsWindow.classList.add("hidden");
            searchInput.value = currentLabel
            valueInput.value  = currentValue;
        }
    });
}

window.setupTypeAhead = setupTypeAhead;

