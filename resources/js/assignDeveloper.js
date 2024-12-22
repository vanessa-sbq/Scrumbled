// Place task function to move task to new state
function placeTask(assigned_to, task_id, title, effort, value, state) {
    const taskData = {
        assigned_to: assigned_to,
        task_id: task_id,
        title: title,
        effort: effort,
        value: value,
        state: state
    };

    fetch('/api/tasks/generateForSprint', {
        method: 'POST', // Use POST method
        headers: {
            'Content-Type': 'application/json', // Send JSON data
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF Token for Laravel
        },
        body: JSON.stringify(taskData) // Convert taskData to JSON
    })
        .then(response => response.json()) // Parse the JSON response from the server
        .then(data => {
            if (data) {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');


                const taskElement = doc.body.firstChild;
                const targetContainer = document.querySelector(`#${state}`);




                if (state === "IN_PROGRESS") {
                    taskElement.addEventListener('dragstart', handleDragStart);
                    taskElement.addEventListener('dragend', handleDragEnd);
                    taskElement.querySelector(".cancel-button").addEventListener("click", cancelButtonListener);

                    if (targetContainer.querySelector('.task-placeholder').style.display !== "hidden") {
                        targetContainer.querySelector('.task-placeholder').style = "display: hidden";
                    }

                    targetContainer.appendChild(taskElement);
                }

                if (state === "SPRINT_BACKLOG") {

                    let tableRowElement = document.createElement('tr');

                    tableRowElement.innerHTML = data;

                    console.log(tableRowElement)

                    tableRowElement.querySelector(".state-button").addEventListener("click", stateButtonListener);

                    targetContainer.appendChild(tableRowElement);

                    const checkContainer = document.querySelector("#IN_PROGRESS");

                    if (checkContainer.children.length === 1) {
                        checkContainer.querySelector('.task-placeholder').style = "display: block";
                    }
                }

                const url = this.getAttribute('data-url');

                sendStateChange(url, state).then(data => {
                    if (data.status !== 'success') {
                        alert('Error: Unable to move task at this moment. Please try again later.');
                        window.location.reload();
                    }
                });
            } else {
                alert('Error: Unable to fetch task design. Please try again later.');
                window.location.reload();
            }
        })
        .catch(error => {
            alert(`Error: Unable to fetch task design. Please try again later. ${error}`);
            window.location.reload();
        });
}

// Send state change to the server
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

const assignSidebars = document.querySelectorAll(".assign-sidebar");
const openSidebarButtons = document.querySelectorAll(".open-sidebar-button");
const closeSidebarButtons = document.querySelectorAll(".close-sidebar-button");

console.log({ openSidebarButtons, closeSidebarButtons, assignSidebars });

// Function to open the sidebar
openSidebarButtons.forEach(button => {
    button.addEventListener("click", function () {
        const taskRow = button.closest("tr");
        const assignSidebar = taskRow.querySelector(".assign-sidebar");
        if (assignSidebar) {
            console.log("Opening sidebar...");
            assignSidebar.classList.remove("translate-x-full");
            assignSidebar.classList.add("translate-x-0");
        }
    });
});

// Function to close the sidebar
closeSidebarButtons.forEach(button => {
    button.addEventListener("click", function () {
        const assignSidebar = button.closest(".assign-sidebar");
        if (assignSidebar) {
            console.log("Closing sidebar...");
            assignSidebar.classList.remove("translate-x-0");
            assignSidebar.classList.add("translate-x-full");
        }
    });
});

// Optional: Close sidebar when clicking outside of it
document.addEventListener("click", function (event) {
    assignSidebars.forEach(sidebar => {
        if (
            !sidebar.contains(event.target) &&
            !event.target.closest(".open-sidebar-button")
        ) {
            sidebar.classList.remove("translate-x-0");
            sidebar.classList.add("translate-x-full");
        }
    });
});

// Assign developer button handler
document.querySelectorAll(".assign-button").forEach(button => {
    button.addEventListener("click", function () {
        const developerId = this.getAttribute("data-developer-id");
        const taskId = this.getAttribute("data-task-id");

        fetch(`/tasks/${taskId}/assign`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({ user_id: developerId }),
        })
            .then(response => response.json())
            .then(data => {
                console.log("Server Response:", data);

                if (data.status === "success") {
                    const taskRow = document.querySelector(`tr[data-task-id="${taskId}"]`);
                    if (taskRow) {
                        const assignedCell = taskRow.querySelector("td:nth-child(4)");
                        const startButtonCell = taskRow.querySelector("td:nth-child(5)");

                        // Update the "Assigned To" cell with the user component
                        assignedCell.innerHTML = data.userComponent;

                        // Log the assigned user status
                        console.log("Assigned to Current User:", data.assignedToCurrentUser);

                        // Show "Start" button only if the logged-in user is the one assigned
                        if (data.assignedToCurrentUser) {
                            startButtonCell.innerHTML = `
                                <button data-url="/tasks/${taskId}/state" data-state="IN_PROGRESS" data-task-id="${taskId}"
                                        class="state-button bg-primary text-white px-3 py-1 rounded-md hover:bg-blue-700 transition">
                                    Start
                                </button>`;
                        } else {
                            // Clear the cell if not assigned to the current user
                            startButtonCell.innerHTML = '';
                        }

                        // Close the sidebar
                        const assignSidebar = taskRow.querySelector(".assign-sidebar");
                        if (assignSidebar) {
                            assignSidebar.classList.remove("translate-x-0");
                            assignSidebar.classList.add("translate-x-full");
                        }

                        // Reattach event listeners for the "Start" button and other dynamic buttons
                        attachStateButtonListeners();
                    }
                } else {
                    alert(data.message || "Error assigning developer.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("There was an error assigning the developer.");
            });
    });
});

// Delegate "Start" button behavior to the document or a parent container
function attachStateButtonListeners() {
    document.querySelectorAll(".state-button").forEach(button => {
        button.addEventListener("click", stateButtonListener);
    });

    document.querySelectorAll(".cancel-button").forEach(button => {
        button.addEventListener("click", cancelButtonListener);
    });
}

// State button listener
function stateButtonListener(event) {
    event.preventDefault();

    // Grab the grandparent of the button (Task inside to-do)
    let task = event.target.parentElement.parentElement;

    // grab the stuff we really need
    let title = task.querySelector('.task_title').innerText;
    let effort = task.querySelector('.task_effort').innerText;
    let value = task.querySelector('.task_value').innerText;
    let assigned_to = task.querySelector('.user_profile_data').innerText;
    let task_id = event.target.getAttribute('data-task-id')

    console.log(title);
    console.log(effort);
    console.log(value);
    console.log(assigned_to);
    console.log(task_id);

    const boundPlaceTask = placeTask.bind(event.target);

    boundPlaceTask(assigned_to, task_id, title, effort, value, "IN_PROGRESS")

    task.remove();
}

// Cancel button listener
function cancelButtonListener(event) {
    event.preventDefault()

    // Grab the parent of the button
    let task = event.target.parentElement;

    // grab the stuff we really need
    let title = task.querySelector('.task_title').innerText;
    let effort = task.querySelector('.task_effort').innerText;
    let value = task.querySelector('.task_value').innerText;
    let assigned_to = task.getAttribute('data-assigned-to')
    let task_id = task.getAttribute('data-task-id')

    console.log(title);
    console.log(effort);
    console.log(value);
    console.log(assigned_to);
    console.log(task_id);

    console.log(event.target.parentElement)


    const boundPlaceTask = placeTask.bind(event.target);

    boundPlaceTask(assigned_to, task_id, title, effort, value, 'SPRINT_BACKLOG')

    task.remove();
}



// Initial call to attach listeners for already existing buttons
attachStateButtonListeners();


