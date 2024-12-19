function setScrumMaster(event) {
    event.preventDefault();

    const userId = event.currentTarget.getAttribute('data-user-id');
    const projectSlug = window.location.pathname.split('/').at(2);

    const data = {
        userId: userId,
        slug: projectSlug
    };

    fetch('/api/projects/team/setScrumMaster', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                //alert(data.message);
                location.reload();
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An unexpected error occurred. Please try again.');
        });
}

function removeScrumMaster(event) {
    event.preventDefault();

    const userId = event.currentTarget.getAttribute('data-user-id');
    const projectSlug = window.location.pathname.split('/').at(2);

    const data = {
        userId: userId,
        slug: projectSlug
    };

    fetch('/api/projects/team/removeScrumMaster', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                //alert(data.message);
                location.reload();
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An unexpected error occurred. Please try again.');
        });
}

let selectedUserId = null;
let selectedProjectSlug = null;

function showRemoveDeveloperModal(event) {
    event.preventDefault();

    // Get attributes from the button
    const button = event.currentTarget;
    const projectSlug =  window.location.pathname.split('/').at(2);
    const userId = button.getAttribute('data-user-id');
    const developerName = button.getAttribute('data-user-name');
    const removeSmButton = document.querySelector('.remove_sm_button');

    // Store values globally to use later.
    selectedUserId = userId;
    selectedProjectSlug = projectSlug;

    // Fill modal.
    document.getElementById('fill_user_name').textContent = `Are you sure you want to remove ${developerName}?`;

    if (removeSmButton && removeSmButton.getAttribute('data-user-id') === userId) {
        document.getElementById('extra').textContent = `Removing ${developerName} will leave the project with no Scrum Master.`;
    } else {
        document.getElementById('extra').textContent = '';
    }

    openModal('remove_developer_modal');
}

function removeDeveloperHelper() {
    if (!selectedUserId || !selectedProjectSlug) return;

    // Prepare payload
    const data = {
        userId: selectedUserId,
        slug: selectedProjectSlug
    };

    // Send POST request to the server
    fetch('/api/projects/team/removeDeveloper', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                //alert(data.message);
                window.location.replace(data['redirect']);
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An unexpected error occurred. Please try again.');
        });
}

document.querySelectorAll('.remove_dev_button').forEach((button) => {
    button.addEventListener('click', showRemoveDeveloperModal);
});

document.querySelectorAll('.set_as_sm_button').forEach((button) => {
    button.addEventListener('click', setScrumMaster);
});

document.querySelectorAll('.remove_sm_button').forEach((button) => {
    button.addEventListener('click', removeScrumMaster);
});