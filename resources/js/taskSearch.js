function fetchTasks(url) {
    const resultContainer = document.querySelector('#task-results-container');
    fetch(url)
    .then(response => {
        const contentType = response.headers.get('content-type');
        if (!response.ok) {
            console.error('Fetch error:', response.status, response.statusText);
            return response.text().then(text => { throw new Error(text); });
        }
        if (contentType && contentType.indexOf('application/json') !== -1) {
            return response.json();
        } else {
            return response.text().then(text => { throw new Error('Expected JSON, got: ' + text); });
        }
    })
    .then(data => {
        console.log('Fetch response data:', data); // Debugging statement
        // Update the results container with the fetched data
        resultContainer.innerHTML = data;
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });
}

function searchHelper(savedContainer) {
    let container = document.querySelector('#task-results-container')
    const searchInput = document.querySelector('#task-search-input');
    const pagination = document.querySelector('#task-pagination-container');
    const filterInput = document.querySelector('#task-filter-input');
    
    let debounceTimer;
    
    let paginationRemoved = false;
    const query = searchInput.value;

    // Clear the previous timeout if the user is still typing
    clearTimeout(debounceTimer);

    // Extract the slug from the URL
    const pathMatch = window.location.pathname.match(/^\/projects\/([^\/]+)\/tasks$/);
    const slug = pathMatch[1];

    // Set a new timeout to delay the fetch call
    debounceTimer = setTimeout(() => {
        if (query || (filterInput !== null && filterInput !== '')) {
            if (pagination) {
                pagination.remove();
                paginationRemoved = true;
            }
            let url = `/api/projects/${slug}/tasks/search?search=${query}`;
            console.log(url);
            fetchTasks(url)
        } else {
            container.innerHTML = savedContainer;
            if (paginationRemoved) {
                container.appendChild(pagination);
                paginationRemoved = false;
            }
            //resultContainer.innerHTML = '';
            //window.location.href = '/profiles';;
        }
    }, 500);
}

window.onload = () => {
    const searchInput = document.querySelector('#task-search-input');
    const filterInput = document.querySelector('#task-filter-input');

    fetchTasks(`/api/projects/${window.location.pathname.match(/^\/projects\/([^\/]+)\/tasks$/)[1]}/tasks/search?search=${''}`)
    let savedContainer = document.querySelector('#task-results-container').innerHTML;
    if (filterInput) {
        filterInput.addEventListener('input', () => searchHelper(savedContainer))
    }
    searchInput.addEventListener('input', () => searchHelper(savedContainer));
    
};
