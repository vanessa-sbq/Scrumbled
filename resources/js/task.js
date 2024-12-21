function sendStateChange(url, state) {
    return fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ state })
    })
        .then(response => response.json())
        .catch(error => {
            console.error('Error:', error);
            return { status: 'error', message: 'Not allowed. Are you a Product Owner?' };
        });
}

function placeTask(taskElement, url, state, target) {
    sendStateChange(url, state)
        .then(data => {
            if (data.status === 'success') {
                const targetContainer = document.querySelector(`#${target}`);
                targetContainer.appendChild(taskElement);
            }
        })
        .finally(() => location.reload()); // Reload to reflect changes
}

function stateButtonListener() {
    const url = this.getAttribute('data-url');
    const state = this.getAttribute('data-state');

    const taskElement = this.closest('.task-card');
    placeTask(taskElement, url, state, 'IN_PROGRESS');
}

function cancelButtonListener() {
    const url = this.getAttribute('data-url');
    const state = this.getAttribute('data-state');

    const taskElement = this.closest('.task-card');
    placeTask(taskElement, url, state, 'SPRINT_BACKLOG');
}

document.querySelectorAll('.cancel-button').forEach(button => {
    button.addEventListener('click', cancelButtonListener);
});

document.querySelectorAll('.state-button').forEach(button => {
    button.addEventListener('click', stateButtonListener);
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