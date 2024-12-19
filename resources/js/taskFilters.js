document.addEventListener("DOMContentLoaded", function () {
    const taskResultsContainer = document.getElementById("task-results-container");
    const stateInput = document.getElementById("state-input");
    const valueInput = document.getElementById("value-input");
    const searchInput = document.getElementById("task-search-input");
    const taskSearchForm = document.getElementById("task-search");

    // Function to fetch filtered tasks
    function fetchFilteredTasks(event) {
        if (event) event.preventDefault();

        // Get current filter values
        const query = searchInput.value.trim();
        const state = stateInput.value;
        const value = valueInput.value;

        // Append existing filters to the search URL
        const params = new URLSearchParams({ query, state, value });
        const url = `${taskSearchForm.action}?${params.toString()}`;

        // Update the URL without reloading the page
        history.replaceState(null, "", url);

        fetch(url, {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Accept": "application/json",
            },
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                if (data.html) {
                    taskResultsContainer.innerHTML = data.html;
                } else {
                    taskResultsContainer.innerHTML = `
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No tasks found.
                            </td>
                        </tr>
                    `;
                }
            })
            .catch((error) => {
                console.error("Error fetching tasks:", error);
                taskResultsContainer.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-red-500">
                            Error loading tasks. Please try again.
                        </td>
                    </tr>
                `;
            });
    }

    // Attach event listeners for filters and search
    [stateInput, valueInput].forEach((input) =>
        input.addEventListener("change", fetchFilteredTasks)
    );
    taskSearchForm.addEventListener("submit", fetchFilteredTasks);
});
