function adminUserViewProfile(id) {
    const username = id.substring("admin_view_user_modal_".length);
    const url = `/admin/users/${encodeURIComponent(username)}/edit`;
    window.history.pushState(null, null, url);  // Change the URL
    window.location.href = url;
    closeModal(id);
}

function adminCloseModal(id){
    closeModal(id);
}

function deleteUser(event) {
    // Get necessary data
    const userId = document.getElementById('delete_user_modal').getAttribute('data-user-id');

    // Make the API request
    fetch('/admin/api/users/delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({
            userId: userId,
        }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while leaving the project.');
        });

    closeModal(userId);
}

document.querySelectorAll('.admin-user-delete-profile').forEach(button => {
   button.addEventListener('click', () => {
       document.getElementById('delete_user_modal').setAttribute('data-user-id', button.id);
       openModal('delete_user_modal')
   });
});

document.querySelectorAll('.admin-user-view-profile').forEach(button => {
    button.addEventListener('click', function() {
        const username = this.getAttribute('data-username');
        openModal('admin_view_user_modal_' + username);
    });
});