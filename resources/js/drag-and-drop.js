const taskCards = document.querySelectorAll('.task-card');
const columns = document.querySelectorAll('.task-column');
let sourceColumnId = null;
const userId_dragndrop = document.querySelector('meta[name="user-id"]').getAttribute('content');
const canManageProject = document.querySelector('meta[name="can-manage-project"]').getAttribute('content') === 'true';

taskCards.forEach(card => {
    card.addEventListener('dragstart', handleDragStart);
    card.addEventListener('dragend', handleDragEnd);
});

columns.forEach(column => {
    column.addEventListener('dragover', handleDragOver);
    column.addEventListener('dragleave', handleDragLeave);
    column.addEventListener('drop', handleDrop);
    updatePlaceholderVisibility(column);
});

function handleDragStart(event) {
    const taskCard = event.target.closest('.task-card');
    if (!taskCard) {
        event.preventDefault();
        return;
    }
    sourceColumnId = taskCard.closest('.task-column').id;
    event.dataTransfer.setData('text/plain', taskCard.dataset.taskId);
    taskCard.classList.add('dragging');
}

function handleDragEnd(event) {
    const taskCard = event.target.closest('.task-card');
    if (taskCard) {
        taskCard.classList.remove('dragging');
    }
    columns.forEach(column => {
        column.classList.remove('drag-over');
        updatePlaceholderVisibility(column);
    });
    sourceColumnId = null;
}

function handleDragOver(event) {
    event.preventDefault();
    const sourceColumn = sourceColumnId;
    if (event.currentTarget.id !== sourceColumn && !event.currentTarget.classList.contains('drag-over')) {
        event.currentTarget.classList.add('drag-over');
    }
}

function handleDragLeave(event) {
    // Check if the mouse has actually left the column
    const relatedTarget = event.relatedTarget;
    if (!event.currentTarget.contains(relatedTarget)) {
        if (event.currentTarget.classList.contains('drag-over')) {
            event.currentTarget.classList.remove('drag-over');
        }
    }
}

function handleDrop(event) {
    event.preventDefault();
    const taskId = event.dataTransfer.getData('text/plain');
    const sourceColumn = sourceColumnId;
    const taskCard = document.querySelector(`[data-task-id="${taskId}"]`);
    const targetColumn = event.currentTarget.id.toUpperCase(); // Convert to uppercase

    // Ensure the taskCard is valid
    if (!taskCard) {
        console.error('Invalid task card');
        return;
    }

    // Prevent moving to the same column
    if (sourceColumn === targetColumn) {
        return;
    }

    // Check if the user has permission to move the task
    if (!canMoveTask(taskCard, targetColumn)) {
        alert('You do not have permission to move this task.');
        return;
    }

    // Move the task card to the new column
    event.currentTarget.appendChild(taskCard);

    if (targetColumn !== 'IN_PROGRESS') {
        const cancelButton = taskCard.querySelector('.cancel-button');
        if (cancelButton) {
            cancelButton.remove();
        }
    }

    if (targetColumn === 'IN_PROGRESS') {
        let cancelButton = taskCard.querySelector('.cancel-button');
        cancelButton = document.createElement('button');
        cancelButton.className = 'cancel-button bg-gray-400 text-white px-3 py-1 rounded-md hover:bg-gray-500 transition';
        cancelButton.textContent = 'Cancel';
        cancelButton.setAttribute('data-url', `/tasks/${taskId}/state`);
        cancelButton.setAttribute('data-state', 'SPRINT_BACKLOG');
        cancelButton.addEventListener('click', cancelButtonListener);
        taskCard.appendChild(cancelButton);
    }

    // Perform the move (e.g., send an AJAX request to update the task status)
    updateTaskStatus(taskId, targetColumn);

    // Remove the drag-over class and update placeholder visibility
    event.currentTarget.classList.remove('drag-over');
    updatePlaceholderVisibility(event.currentTarget);
}

function canMoveTask(taskCard, targetColumn) {
    const assignedTo = taskCard.dataset.assignedTo;
    if (canManageProject) {
        return true;
    }
    if (assignedTo === userId_dragndrop && (targetColumn === 'IN_PROGRESS' || targetColumn === 'DONE') && sourceColumnId !== 'ACCEPTED') {
        return true;
    }
    return false;
}

function updateTaskStatus(taskId, targetColumn) {
    // Implement your logic to update the task status
    // For example, send an AJAX request to update the task status in the database
    fetch(`/tasks/${taskId}/state`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ state: targetColumn })
    })
        .then(response => response.json())
        .then(data => {
        })
        .catch(error => {
            console.error('Error updating task state:', error);
        });
}

function updatePlaceholderVisibility(column) {
    const placeholder = column.querySelector('.task-placeholder');
    const hasTasks = column.querySelectorAll('.task-card').length > 0;
    placeholder.style.display = hasTasks ? 'none' : 'block';
}