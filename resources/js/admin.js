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


document.querySelectorAll('.admin-user-view-profile').forEach(button => {
    button.addEventListener('click', function() {
        const username = this.getAttribute('data-username');
        openModal('admin_view_user_modal_' + username);
    });
});