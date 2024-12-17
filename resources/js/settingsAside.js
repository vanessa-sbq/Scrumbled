function leaveProject() {
    // Get necessary data
    const projectSlug = window.location.pathname.split('/').at(2);
    const userId = document.querySelector('.leave_project_button').id;

    // Make the API request
    fetch('/api/projects/leaveProject', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({
            slug: projectSlug,
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
}

if (document.querySelector('.leave_project_button') != null) {
    document.querySelector('.leave_project_button').addEventListener('click',() => {openModal('leave_project_modal');});
}
