document.addEventListener('DOMContentLoaded', function () {
    const taskCards = document.querySelectorAll('.task-card');
    const columns = document.querySelectorAll('.task-column');
    let sourceColumnId = null;

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
        console.log('Drag Start:', { taskId: taskCard.dataset.taskId, sourceColumnId });
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
        const targetColumn = event.currentTarget.id;

        console.log('Drop:', { taskId, sourceColumn, targetColumn });

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
        if (!canMoveTask(taskId, targetColumn)) {
            alert('You do not have permission to move this task.');
            return;
        }

        // Move the task card to the new column
        event.currentTarget.appendChild(taskCard);

        // Perform the move (e.g., send an AJAX request to update the task status)
        updateTaskStatus(taskId, targetColumn);

        // Remove the drag-over class and update placeholder visibility
        event.currentTarget.classList.remove('drag-over');
        updatePlaceholderVisibility(event.currentTarget);
    }

    function canMoveTask(taskId, targetColumn) {
        // Implement your logic to check if the user has permission to move the task
        // For example, check if the user is the task owner or a product owner
        // Return true if the user has permission, false otherwise
        return true; // Replace with your actual logic
    }

    function updateTaskStatus(taskId, targetColumn) {
        // Implement your logic to update the task status
        // For example, send an AJAX request to update the task status in the database
        console.log(`Task ${taskId} moved to ${targetColumn}`);
    }

    function updatePlaceholderVisibility(column) {
        const placeholder = column.querySelector('.task-placeholder');
        const hasTasks = column.querySelectorAll('.task-card').length > 0;
        placeholder.style.display = hasTasks ? 'none' : 'block';
    }
});