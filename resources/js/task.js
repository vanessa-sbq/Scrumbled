console.log('task.js loaded');

function placeTask(taskElement, url, state) {
    let inProgressContainer = document.querySelector('#in-progress');
    let doneContainer = document.querySelector('#done');
    let acceptedContainer = document.querySelector('#accepted');

    taskElement.parentNode.removeChild(taskElement);

    let buttons = taskElement.querySelector('#buttons');

    buttons.innerText = '';

    let rightArrow = document.createElement("button");
    rightArrow.innerText = "➡️";
    rightArrow.className = "arrow-button";
    rightArrow.setAttribute('data-url', url);

    let leftArrow = document.createElement("button");
    leftArrow.innerText = "⬅️";
    leftArrow.className = "arrow-button";
    leftArrow.setAttribute('data-url', url);

    switch (state) {
        case 'IN_PROGRESS':
            rightArrow.setAttribute('data-state', 'DONE');
            rightArrow.addEventListener('click', buttonListener);
            buttons.appendChild(rightArrow); // Append the right button
            inProgressContainer.appendChild(taskElement); // Append to the right table.
            break;
        case 'DONE':
            leftArrow.setAttribute('data-state', 'IN_PROGRESS');
            leftArrow.addEventListener('click', buttonListener);
            buttons.appendChild(leftArrow); // Append the left button

            rightArrow.setAttribute('data-state', 'ACCEPTED');
            rightArrow.addEventListener('click', buttonListener);
            buttons.appendChild(rightArrow); // Append the right button

            doneContainer.appendChild(taskElement);
            break;
        case 'ACCEPTED':
            leftArrow.setAttribute('data-state', 'DONE');
            leftArrow.addEventListener('click', buttonListener);
            buttons.appendChild(leftArrow); // Append the left button
            acceptedContainer.appendChild(taskElement);
            break;
        default:
            alert('An error occurred.');
            location.reload();
            break;
    }
}

function buttonListener() {
    const url = this.getAttribute('data-url');
    const state = this.getAttribute('data-state');

    placeTask(this.parentElement.parentElement, url, state);

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ state })
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