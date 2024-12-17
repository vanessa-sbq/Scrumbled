const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

function adminUserViewProfile(id) {
    fetch('/api/admin/changeVisibility', {
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


// TODO: Remove?
/* window.onload = () => {
    let savedContainer = document.querySelector('#profileList').cloneNode(true);
    const searchInput = document.querySelector('#search-input');
    const filterInput = document.querySelector('#filter-input');

    if (filterInput) {
        filterInput.addEventListener('input', () => searchHelper(savedContainer))
    }

    searchInput.addEventListener('input', () => searchHelper(savedContainer));
}; */


window.onload = () => {
    console.log("asdadsd");
};

document.querySelector('#admin_user_view_profile').addEventListener('click', () => {openModal('admin_view_user_modal');});
