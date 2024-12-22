const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const data = {
    username: window.location.pathname.split('/').at(2),
};

function changeVisibility(id) {
    fetch('/api/profiles/changeProfileVisibility', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
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

function deleteProfile(id) {
    fetch('/api/profiles/deleteProfile', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
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

document.getElementById('changeUsernameBtn').addEventListener('click', function(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const usernameError = document.getElementById('usernameError');
    usernameError.style.display = "none"; // Clear any previous error

    // Validate title length
    if (username.length <= 0) {
        username.textContent = "Username must not be empty.";
        usernameError.style.display = "block";
        return; // Prevent the fetch request
    }

    // Prepare form data
    const formData = {
        newUsername: username,
        oldUsername: window.location.pathname.split('/').at(2)
    }

    // Send the data via fetch
    fetch('/api/profiles/changeUsername', {
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
                //alert(data.message); // TODO: Toast Notification ?
                window.location.replace(data.redirect)
            } else {
                alert(data.message); // Error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('There was an error processing your request.');
        });
});


document.getElementById('changeEmailBtn').addEventListener('click', function(event) {
    event.preventDefault();
    const email = document.getElementById('email').value;
    const emailError = document.getElementById('emailError');
    emailError.style.display = "none"; // Clear any previous error

    // Validate title length
    if (email.length <= 0) {
        email.textContent = "Email must not be empty.";
        emailError.style.display = "block";
        return; // Prevent the fetch request
    }

    // Prepare form data
    const formData = {
        email: email,
        username: window.location.pathname.split('/').at(2)
    }

    // Send the data via fetch
    fetch('/api/profiles/changeEmail', {
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
                //alert(data.message); // TODO: Toast Notification ?
                window.location.replace(data.redirect)
            } else {
                alert(data.message); // Error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('There was an error processing your request.');
        });
});

document.getElementById('changeFullNameBtn').addEventListener('click', function(event) {
    event.preventDefault();
    const fullName = document.getElementById('full_name').value;
    const fullNameError = document.getElementById('fullNameError');
    fullNameError.style.display = "none"; // Clear any previous error

    // Validate title length
    if (fullName.length <= 0) {
        fullName.textContent = "Email must not be empty.";
        fullNameError.style.display = "block";
        return; // Prevent the fetch request
    }

    // Prepare form data
    const formData = {
        full_name: fullName,
        username: window.location.pathname.split('/').at(2)
    }

    // Send the data via fetch
    fetch('/api/profiles/changeFullName', {
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
                //alert(data.message); // TODO: Toast Notification ?
                window.location.replace(data.redirect)
            } else {
                alert(data.message); // Error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('There was an error processing your request.');
        });
});

document.getElementById('changeBioBtn').addEventListener('click', function(event) {
    event.preventDefault();
    const bio = document.getElementById('bio').value;
    const bioError = document.getElementById('bioError');
    bioError.style.display = "none"; // Clear any previous error

    // Validate description length
    if (bio.length > 5000) {
        bioError.textContent = "Bio cannot exceed 5000 characters.";
        bioError.style.display = "block";
        return; // Prevent the fetch request
    }

    // Prepare form data
    const formData = {
        bio: bio,
        username: window.location.pathname.split('/').at(2)
    }

    // Send the data via fetch
    fetch('/api/profiles/changeBio', {
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

document.querySelector('#change_profile_visibility').addEventListener('click', () => {openModal('visibility_modal');});
document.querySelector('#delete_profile').addEventListener('click',() => {openModal('delete_modal');});

