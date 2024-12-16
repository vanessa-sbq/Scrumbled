const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const data = {
    slug: window.location.pathname.split('/').at(2), // Replace with actual project ID
};

function changeVisibility(id) {
    fetch('/api/projects/changeVisibility', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken  // Add the CSRF token to the headers
        },
        body: JSON.stringify(data)
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
    closeModal(id);
}

function transferOwnership(id) {

}

function archiveProject(id) {
    fetch('/api/projects/archiveProject', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken  // Add the CSRF token to the headers
        },
        body: JSON.stringify(data)
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
    closeModal(id);
}

function deleteProject(id) {
    fetch('/api/projects/deleteProject', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken  // Add the CSRF token to the headers
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            const redirect = data['redirect'];
            if (redirect != null) {
                window.location.replace(redirect);
            } else {
                alert(data['message'])
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    closeModal(id);
}
function executeOption(event) {
    switch(event.srcElement.id) {
        case 'change_visibility':
            break;
        case 'archive_project':
            console.log("REMOVE_ME: archive_project");
            break;
        case 'delete_project':
            console.log("REMOVE_ME: delete_project");
            break;
        default:
            break;
    }
}

// Change Project Title
document.getElementById('changeTitleBtn').addEventListener('click', function(event) {
    event.preventDefault();
    const title = document.getElementById('title').value;
    const titleError = document.getElementById('titleError');
    titleError.style.display = "none"; // Clear any previous error

    // Validate title length
    if (title.length <= 0) {
        titleError.textContent = "Title must not be empty.";
        titleError.style.display = "block";
        return; // Prevent the fetch request
    }

    // Prepare form data
    const formData = {
        title: title,
        slug: window.location.pathname.split('/').at(2)
    }

    // Send the data via fetch
    fetch('/api/projects/changeProjectTitle', {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken  // Add the CSRF token to the headers
        },
        body: JSON.stringify(formData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // alert(data.message); // TODO: Toast Notification ?
                window.location.reload();
            } else {
                alert(data.message); // Error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('There was an error processing your request.');
        });
});

// Change Project Description
document.getElementById('changeDescriptionBtn').addEventListener('click', function(event) {
    event.preventDefault();
    const description = document.getElementById('description').value;
    const descriptionError = document.getElementById('descriptionError');
    descriptionError.style.display = "none"; // Clear any previous error

    // Validate description length
    if (description.length > 5000) {
        descriptionError.textContent = "Description cannot exceed 5000 characters.";
        descriptionError.style.display = "block";
        return; // Prevent the fetch request
    }

    // Prepare form data
    const formData = {
        description: description,
        slug: window.location.pathname.split('/').at(2)
    }

    // Send the data via fetch
    fetch('/api/projects/changeProjectDescription', {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken  // Add the CSRF token to the headers
        },
        body: JSON.stringify(formData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // alert(data.message); // Success message // TODO: Toast Notification ?
                window.location.reload();
            } else {
                alert(data.message); // Error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('There was an error processing your request.');
        });
});

function attachToTransferButton() {
    const inviteButtons = document.querySelectorAll(".transferButton");

    inviteButtons.forEach(button => {
        button.addEventListener("click", function() {
            const userId = button.getAttribute('id');
            console.log('User ID:', userId);


            fetch("/api/projects/transferProject", {
                method: "POST",
                body: JSON.stringify({ slug: window.location.pathname.split('/').at(2), userId: userId }),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.reload();
                        console.log(data['message'])
                    } else {
                        alert('Unable to transfer ownership.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('There was an error processing your request.');
                });
        });
    });
}

function attachToPagination() {
    document.addEventListener('DOMContentLoaded', function () {
        // Delegate click event for all pagination links
        document.getElementById('pagination-container').addEventListener('click', function (e) {
            const target = e.target.closest('a'); // Ensure the closest <a> element is targeted

            if (target && target.tagName === 'A') {
                e.preventDefault(); // Prevent default link behavior

                // Fetch the URL from the link
                const url = target.href;

                // Perform the AJAX request
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.text())
                    .then(html => {
                        // Update the results and pagination with the new content
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Replace the results container
                        const newResults = doc.getElementById('results-container');
                        document.getElementById('results-container').innerHTML = newResults.innerHTML;

                        // Replace the pagination container
                        const newPagination = doc.getElementById('pagination-container');
                        document.getElementById('pagination-container').innerHTML = newPagination.innerHTML;
                    })
                    .catch(error => {
                        console.error('Error fetching pagination data:', error);
                    });
            }
        });
    });
}

let paginationRemoved = false;

function searchHelper(savedContainer) {
    const searchInput = document.querySelector('#search-input');
    const resultContainer = document.querySelector('#results-container');
    const pagination = document.querySelector('#pagination-container');
    const filterInput = document.querySelector('#filter-input');

    let debounceTimer;

    const query = searchInput.value;
    const status = filterInput ? filterInput.value : '';

    clearTimeout(debounceTimer);

    debounceTimer = setTimeout(() => {
        if (query || (filterInput !== null && filterInput !== '')) {
            // Hide the pagination container instead of removing it
            if (pagination) {
                pagination.style.display = 'none';
            }

            let url = `/api/profiles/transferProject/search?search=${query}`;
            if (status) {
                url += `&status=${status}`;
            }

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    resultContainer.innerHTML = data;
                    attachToTransferButton();
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        } else {
            resultContainer.innerHTML = '';

            savedContainer.childNodes.forEach(childNode => {
                if (childNode.id === 'results-container') {
                    childNode.childNodes.forEach(child => {
                        resultContainer.appendChild(child.cloneNode(true));
                    });
                }

                if (childNode.id === 'pagination-container') {
                    // Reattach the pagination and make it visible again
                    const existingPagination = document.querySelector('#pagination-container');
                    if (!existingPagination) {
                        resultContainer.appendChild(childNode.cloneNode(true));
                    } else {
                        existingPagination.style.display = 'block';
                    }
                    attachToPagination();
                    attachToTransferButton();
                }
            });
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

attachToTransferButton()
attachToPagination()
document.querySelector('#change_visibility').addEventListener('click', () => {openModal('visibility_modal');});
document.querySelector('#transfer_ownership').addEventListener('click', () => {openModal('transfer_modal')})
document.querySelector('#archive_project').addEventListener('click', () => {openModal('archive_modal');});
document.querySelector('#delete_project').addEventListener('click',() => {openModal('delete_modal');});