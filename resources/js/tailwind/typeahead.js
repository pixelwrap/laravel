/**
 * Returns the initials (first letters) of each word in the string.
 */
function getWordLetters(str) {
    if (typeof str !== "string" || !str) return "";
    return str
        .trim()
        .split(/\s+/)
        .map((word) => word.charAt(0))
        .join("");
}

/**
 * Sets up type-ahead (autocomplete) functionality.
 */
function setupTypeAhead(
    searchInputId,
    endPoint,
    queryName,
    list,
    imageKey,
    show,
    attach,
    label,
    value,
) {
    const valueInput = document.getElementById(searchInputId);
    const container = valueInput.closest("[data-typeahead-target]");
    if (!container) return;

    const searchInput = container.querySelector("input");
    const resultsWindow = container.querySelector(".type-ahead-results");
    const results = resultsWindow.querySelector("ul");
    const url = new URL(endPoint);

    let currentWorkId = 0,
        searchTimeout,
        currentValue = value,
        currentLabel = label;

    // Helper to clear and show a single message in the results list.
    const showMessage = (message, className) => {
        results.innerHTML = "";
        const li = document.createElement("li");
        li.className = className;
        li.textContent = message;
        results.appendChild(li);
    };

    // Fetch results asynchronously and update the UI.
    const fetchSearchResults = async (query, workId) => {
        url.searchParams.set(queryName, query);
        try {
            const response = await fetch(url).then((res) => res.json());
            if (workId >= currentWorkId) {
                if (response.length > 0) {
                    results.innerHTML = "";
                    response.slice(0, 10).forEach((result) => {
                        const li = document.createElement("li");
                        li.className =
                            "text-sm text-gray-700 dark:text-gray-50 hover:bg-gray-100 dark:hover:bg-gray-900 cursor-pointer";
                        const item = document.createElement("div");
                        item.className = "flex items-center";
                        const labelElem = document.createElement("span");
                        labelElem.textContent = result[list];

                        if (imageKey && result[imageKey]) {
                            const imageContainer =
                                document.createElement("div");
                            imageContainer.className =
                                "mx-2 my-1 relative inline-flex items-center justify-center w-8 h-8 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600";
                            const avatar = document.createElement("span");
                            avatar.className =
                                "font-medium text-gray-600 dark:text-gray-300";
                            avatar.textContent = getWordLetters(result[list])
                                .substring(0, 2)
                                .toUpperCase();
                            const image = document.createElement("img");
                            image.src = result[imageKey];
                            image.onload = () => {
                                imageContainer.innerHTML = "";
                                imageContainer.appendChild(image);
                            };
                            imageContainer.appendChild(avatar);
                            item.appendChild(imageContainer);
                        } else {
                            labelElem.className = "m-2";
                        }
                        item.appendChild(labelElem);
                        li.appendChild(item);
                        li.addEventListener("click", () => {
                            searchInput.value = result[show];
                            valueInput.value = result[attach];
                            currentLabel = searchInput.value;
                            currentValue = valueInput.value;
                            resultsWindow.classList.add("hidden");
                        });
                        results.appendChild(li);
                    });
                } else {
                    setTimeout(() => {
                        showMessage(
                            "No results found.",
                            "px-4 py-2 text-sm text-gray-500 dark:text-gray-50",
                        );
                    }, 500);
                }
            }
        } catch (error) {
            console.error("Error fetching search results:", error);
            showMessage(
                "An error occurred. Please try again.",
                "px-4 py-2 text-sm text-red-500",
            );
        }
    };

    // Listen for input events on the search field.
    searchInput.addEventListener("input", (event) => {
        const query = event.target.value.trim();
        resultsWindow.classList.remove("hidden");
        showMessage(
            "Loading...",
            "px-4 py-2 text-sm text-gray-500 dark:text-gray-50",
        );
        clearTimeout(searchTimeout);
        currentWorkId++;
        if (query.length > 0) {
            searchTimeout = setTimeout(
                () => fetchSearchResults(query, currentWorkId),
                100,
            );
        } else {
            results.innerHTML = "";
            resultsWindow.classList.add("hidden");
        }
    });

    // Hide dropdown when clicking outside.
    document.addEventListener("click", (event) => {
        if (
            !resultsWindow.classList.contains("hidden") &&
            !resultsWindow.contains(event.target) &&
            event.target !== searchInput
        ) {
            resultsWindow.classList.add("hidden");
            searchInput.value = currentLabel;
            valueInput.value = currentValue;
        }
    });
}

export const TypeAhead = {
    init: () => {
        // Automatically initialize all type-ahead components
        const containers = document.querySelectorAll("[data-typeahead-target]");
        containers.forEach((container) => {
            const searchInputId = container.getAttribute(
                "data-typeahead-target",
            );
            const endPoint = container.getAttribute("data-typeahead-action");
            const queryName = container.getAttribute("data-typeahead-query");
            const list = container.getAttribute("data-typeahead-list");
            const imageKey = container.getAttribute("data-typeahead-image");
            const show = container.getAttribute("data-typeahead-show");
            const attach = container.getAttribute("data-typeahead-attach");
            const label = container.getAttribute("data-typeahead-input-value");
            const value = container.getAttribute("data-typeahead-value");
            setupTypeAhead(
                searchInputId,
                endPoint,
                queryName,
                list,
                imageKey,
                show,
                attach,
                label,
                value,
            );
        });
    },
};
