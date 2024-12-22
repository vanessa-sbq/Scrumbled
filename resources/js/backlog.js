function updateCounter(containerId, counterElementId) {
    const taskCount = document.querySelectorAll(`#${containerId} tr`).length;
    const counterElement = document.querySelector(`#${counterElementId}`);
    counterElement.innerText = `(${taskCount})`;
}

function moveTask(taskButton, targetContainerId, newState, url) {
    const taskElement = taskButton.closest('tr'); // Get the task row
    const targetContainer = document.querySelector(`#${targetContainerId}`); // Target container

    // Determine current and target container IDs for counters
    const currentContainerId = taskElement.closest('tbody').id;
    const currentCounterId = currentContainerId === 'backlog-tasks' ? 'backlog-counter' : 'sprint-counter';
    const targetCounterId = targetContainerId === 'backlog-tasks' ? 'backlog-counter' : 'sprint-counter';
    
    taskElement.remove();
    targetContainer.appendChild(taskElement);

    // Update the button's text and class
    if(newState === 'SPRINT_BACKLOG') {
        taskButton.innerText = 'Remove'
        taskButton.classList.remove('add-button')
        taskButton.classList.add('remove-button')
    }
    else {
        taskButton.innerText = 'Add to Sprint'
        taskButton.classList.remove('remove-button')
        taskButton.classList.add('add-button')
    }

    taskButton.setAttribute('data-state', newState);
    taskButton.setAttribute('data-url', url);

    // Update the counters
    updateCounter(currentContainerId, currentCounterId);
    updateCounter(targetContainerId, targetCounterId);
}

function handleTaskStateChange(event) {
    const taskButton = event.currentTarget; // The clicked button
    const state = taskButton.getAttribute('data-state'); // Current state
    const url = taskButton.getAttribute('data-url'); // API endpoint
    const sprint_id = taskButton.getAttribute('id'); // Fetch the current sprint_id

    // Determine target container based on the current state
    const targetContainerId = state === 'BACKLOG' ? 'sprint-tasks' : 'backlog-tasks';
    const newState = state === 'BACKLOG' ? 'SPRINT_BACKLOG' : 'BACKLOG';

    moveTask(taskButton, targetContainerId, newState, url);

    // Send the state change to the server
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ state: newState, sprintID: sprint_id })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'success') {
                // Handle error gracefully
                alert(data.message || 'An error occurred. Task was not moved.');
                location.reload(); // Reload to fix any inconsistencies
            }
        })
        .catch(error => {
            console.error('Error updating task state:', error);
            alert('An unexpected error occurred. Please try again.');
            location.reload(); // Reload to fix any inconsistencies
        });
}

document.querySelectorAll('.add-button, .remove-button').forEach(button => {
    button.addEventListener('click', handleTaskStateChange);
});
