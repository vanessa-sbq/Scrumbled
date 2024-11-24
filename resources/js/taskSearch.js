function searchHelper(savedContainer) {
    let container = document.querySelector('#results-container');
    const searchInput = document.querySelector('#search-input');
    const resultContainer = document.querySelector('#results-container');
    const pagination = document.querySelector('#pagination-container');
    const filterInput = document.querySelector('#filter-input');

    let debounceTimer;
    
    let paginationRemoved = false;
    const query = searchInput.value;
    const status = filterInput ? filterInput.value : '';

    // Clear the previous timeout if the user is still typing
    clearTimeout(debounceTimer);

    // Set a new timeout to delay the fetch call
    debounceTimer = setTimeout(() => {
        if (query || (filterInput !== null && filterInput !== '')) {
            if (pagination) {
                pagination.remove();
                paginationRemoved = true;
            }
            let url = `/api/projects/{slug}/tasks/search?search=${query}`;
            if (status) {
                url += `&status=${status}`;
            }
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Update the results container with the fetched data
                    resultContainer.innerHTML = data;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        } else {
            container.innerHTML = savedContainer;
            if (paginationRemoved) {
                container.appendChild(pagination);
                paginationRemoved = false;
            }
            //resultContainer.innerHTML = '';
            //window.location.href = '/profiles';;
        }
    }, 200);
}

window.onload = () => {

    let savedContainer = document.querySelector('#results-container').innerHTML;

    const searchInput = document.querySelector('#search-input');
    const filterInput = document.querySelector('#filter-input');

    if (filterInput) {
        filterInput.addEventListener('input', () => searchHelper(savedContainer))
    }

    searchInput.addEventListener('input', () => searchHelper(savedContainer));
};
