console.log('task.js loaded');

// Handle arrow button clicks
document.querySelectorAll('.arrow-button').forEach(button => {
    button.addEventListener('click', function () {
        const url = this.getAttribute('data-url');
        console.log(url);
        console.log("click");
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    location.reload();
                } else {
                    alert(data.message || 'An error occurred.');
                }
            })
            .catch(error => console.error('Error:', error));
    });
});

// Handle "Show only my tasks" checkbox
const showMyTasksCheckbox = document.getElementById('showMyTasks');
const userId = document.querySelector('meta[name="user-id"]').getAttribute('content');

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