const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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

document.querySelectorAll('.archive-project-button').forEach((button) => {
    button.addEventListener('click', archiveProject);
});

document.querySelectorAll('.delete-project-button').forEach((button) => {
        button.addEventListener('click', deleteProject);
});