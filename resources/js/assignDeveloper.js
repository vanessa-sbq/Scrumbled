document.addEventListener("DOMContentLoaded", function () {
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
                                <button data-url="/tasks/${taskId}/state" data-state="IN_PROGRESS"
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
        // Re-bind the "state-button" listeners after the button is dynamically added
        document.querySelectorAll(".state-button").forEach(button => {
            button.removeEventListener("click", stateButtonListener); // Ensure no duplicate listeners
            button.addEventListener("click", stateButtonListener);
        });

        // Re-bind the "cancel-button" listeners after the button is dynamically added
        document.querySelectorAll(".cancel-button").forEach(button => {
            button.removeEventListener("click", cancelButtonListener); // Ensure no duplicate listeners
            button.addEventListener("click", cancelButtonListener);
        });
    }

    // State button listener
    function stateButtonListener() {
        const url = this.getAttribute('data-url');
        const state = this.getAttribute('data-state');
        const taskElement = this.closest('.task-card');
        placeTask(taskElement, url, state, 'IN_PROGRESS');
    }

    // Cancel button listener
    function cancelButtonListener() {
        const url = this.getAttribute('data-url');
        const state = this.getAttribute('data-state');
        const taskElement = this.closest('.task-card');
        placeTask(taskElement, url, state, 'SPRINT_BACKLOG');
    }

    // Place task function to move task to new state
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

    // Initial call to attach listeners for already existing buttons
    attachStateButtonListeners();
});
