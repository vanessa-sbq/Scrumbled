console.log('task.js loaded');

function placeTask(taskElement, url) {
    let task_in_progress = document.querySelector('#in-progress');
    let task_done = document.querySelector('#done');
    let task_accepted = document.querySelector('#accepted');
    let urlObject = new URL(url);
    let pathSegments = urlObject.pathname.split('/').filter(segment => segment);
    const lastPathSegment = pathSegments[pathSegments.length - 1]; // Get the actual last segment

    taskElement.parentNode.removeChild(taskElement);

    let buttons = taskElement.querySelector('#buttons');

    buttons.innerText = '';

    let rightArrow = document.createElement("button");
    rightArrow.innerText = "➡️";
    rightArrow.className = "arrow-button";

    let leftArrow = document.createElement("button");
    leftArrow.innerText = "⬅️";
    leftArrow.className = "arrow-button";

    console.log(pathSegments);

    switch (lastPathSegment) {
        case 'start':
            pathSegments[pathSegments.length - 1] = 'complete';
            urlObject.pathname = '/' + pathSegments.join('/');
            rightArrow.setAttribute('data-url', urlObject.toString());
            rightArrow.addEventListener('click', buttonListener);
            buttons.appendChild(rightArrow); // Append the right button
            task_in_progress.appendChild(taskElement); // Append to the right table.
            break;
        case 'complete':
            pathSegments[pathSegments.length - 1] = 'start';
            urlObject.pathname = '/' + pathSegments.join('/');
            leftArrow.setAttribute('data-url', urlObject.toString());
            leftArrow.addEventListener('click', buttonListener);
            buttons.appendChild(leftArrow); // Append the left button

            pathSegments[pathSegments.length - 1] = 'accept';
            urlObject.pathname = '/' + pathSegments.join('/');
            rightArrow.setAttribute('data-url', urlObject.toString());
            rightArrow.addEventListener('click', buttonListener);
            buttons.appendChild(rightArrow); // Append the right button

            task_done.appendChild(taskElement);
            break;
        case 'accept':
            pathSegments[pathSegments.length - 1] = 'complete';
            urlObject.pathname = '/' + pathSegments.join('/');
            leftArrow.setAttribute('data-url', urlObject.toString());
            leftArrow.addEventListener('click', buttonListener);
            buttons.appendChild(leftArrow); // Append the left button
            task_accepted.appendChild(taskElement);
            break;
        default:
            alert('An error occurred.');
            location.reload();
            break;
    }
}

function buttonListener() {
    const url = this.getAttribute('data-url');

    placeTask(this.parentElement.parentElement, url);

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'success') {
                alert(data.message || 'An error occurred.');
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
}


document.querySelectorAll('.arrow-button').forEach(button => {
    button.addEventListener('click', buttonListener);
});

// Handle "Show only my tasks" checkbox
const showMyTasksCheckbox = document.getElementById('showMyTasks');
const userId = document.querySelector('meta[name="user-id"]').getAttribute('content');

if (showMyTasksCheckbox) {
    showMyTasksCheckbox.addEventListener('change', function () {
        const showMyTasks = this.checked;
        document.querySelectorAll('.task-card').forEach(taskCard => {
            const assignedTo = taskCard.getAttribute('data-assigned-to');
            if (showMyTasks && assignedTo != userId) {
                taskCard.style.display = 'none';
            } else {
                taskCard.style.display = 'block';
            }
        });
    });
}