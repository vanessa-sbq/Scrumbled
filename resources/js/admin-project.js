const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function attachToButtons() {
    document.querySelectorAll('.archive-project-button').forEach((button) => {
        button.addEventListener('click', archiveProject);
    });

    document.querySelectorAll('.delete-project-button').forEach((button) => {
        button.addEventListener('click', deleteProject);
    });
}

function archiveProject(event) {
    event.preventDefault();
    const projectSlug = event.srcElement.getAttribute('data-project-slug')

    fetch('/api/projects/archiveProject', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({slug : projectSlug})
    })
        .then(response => response.json())
        .then(data => {
            if (data['status'] === 'success') {
                window.location.reload();
            } else {
                alert(data['message'])
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}

function deleteProject(event) {
    event.preventDefault();
    console.log("hello")

    const projectSlug = event.srcElement.getAttribute('data-project-slug')

    fetch('/api/projects/deleteProject', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({slug : projectSlug})
    })
        .then(response => response.json())
        .then(data => {
            if (data['status'] === 'success') {
                window.location.reload();
            } else {
                alert(data['message'])
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}

let paginationRemoved = false;

function searchHelper(savedContainer) {
    const searchInput = document.querySelector('#search-input');
    const resultContainer = document.querySelector('#results-container');
    const pagination = document.querySelector('#pagination-container');
    const filterInputVisibility = document.querySelector('#filter-input-visibility');
    const filterInputArchival = document.querySelector('#filter-input-archival');

    let debounceTimer;

    const query = searchInput.value;
    const statusVisibility = filterInputVisibility ? filterInputVisibility.value : '';
    const statusArchival = filterInputArchival ? filterInputArchival.value : '';

    // Clear the previous timeout if the user is still typing
    clearTimeout(debounceTimer);

    // Set a new timeout to delay the fetch call
    debounceTimer = setTimeout(() => {
        if (query || (statusVisibility !== null && statusVisibility !== '') || (statusArchival !== null && statusArchival !== '') ) {
            if (pagination) {
                pagination.remove();
            }
            let url = `/api/projects/search?search=${query}`;
            if (statusVisibility) {
                url += `&statusVisibility=${statusVisibility}`;
            }
            if (statusArchival) {
                url += `&statusArchival=${statusArchival}`;
            }
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Update the results container with the fetched data
                    resultContainer.innerHTML = data;
                    attachToButtons();
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
                attachToButtons();
            })
        }
    }, 200);
}

let savedContainer = document.querySelector('#projectList').cloneNode(true);

const searchInput = document.querySelector('#search-input');
const filterInputVisibility = document.querySelector('#filter-input-visibility');
const filterInputArchival = document.querySelector('#filter-input-archival');

if (filterInputVisibility) {
    filterInputVisibility.addEventListener('input', () => searchHelper(savedContainer))
}

if (filterInputArchival) {
    filterInputArchival.addEventListener('input', () => searchHelper(savedContainer))
}

searchInput.addEventListener('input', () => searchHelper(savedContainer));

attachToButtons();
