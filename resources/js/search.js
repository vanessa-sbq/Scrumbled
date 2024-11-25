let paginationRemoved = false;

function searchHelper(savedContainer) {
    const searchInput = document.querySelector('#search-input');
    const resultContainer = document.querySelector('#results-container');
    const pagination = document.querySelector('#pagination-container');
    const filterInput = document.querySelector('#filter-input');

    let debounceTimer;

    const query = searchInput.value;
    const status = filterInput ? filterInput.value : '';

    // Clear the previous timeout if the user is still typing
    clearTimeout(debounceTimer);

    // Set a new timeout to delay the fetch call
    debounceTimer = setTimeout(() => {
        if (query || (filterInput !== null && filterInput !== '')) {
            if (pagination) {
                pagination.remove();
            }
            let url = `/api/profiles/search?search=${query}`;
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
            resultContainer.innerHTML = '';

            savedContainer.childNodes.forEach( childNode => {
                if (childNode.id === 'results-container') {
                    childNode.childNodes.forEach(child => {
                        resultContainer.appendChild(child.cloneNode(true));
                    });
                }

                if (childNode.id === 'pagination-container') {
                    childNode.childNodes.forEach(child => {
                        resultContainer.appendChild(child.cloneNode(true));
                    });
                }


            })
        }
    }, 200);
}

window.onload = () => {
    let savedContainer = document.querySelector('#profileList').cloneNode(true);

    const searchInput = document.querySelector('#search-input');
    const filterInput = document.querySelector('#filter-input');

    if (filterInput) {
        filterInput.addEventListener('input', () => searchHelper(savedContainer))
    }

    searchInput.addEventListener('input', () => searchHelper(savedContainer));
};
