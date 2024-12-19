/* function showToast(message) {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();

    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast bg-blue-500 text-white py-2 px-4 rounded shadow-md mb-4 
        transform translate-x-full opacity-0 transition-transform duration-200 ease-in-out`;
    toast.innerText = message;

    // Append toast to the container
    toastContainer.appendChild(toast);

    // Trigger enter animation
    requestAnimationFrame(() => {
        toast.classList.remove('translate-x-full', 'opacity-0');
        toast.classList.add('translate-x-0', 'opacity-100');
    });

    // Automatically remove the toast after 3 seconds with an exit animation
    setTimeout(() => {
        toast.classList.remove('translate-x-0', 'opacity-100');
        toast.classList.add('translate-x-full', 'opacity-0');
        
        // Remove the toast after the exit transition completes
        setTimeout(() => {
            toast.remove();
        }, 500); // Match the duration of `transition-transform` (500ms)
    }, 3000); // Duration to display the toast
}

// Helper to create the toast container if it doesn't exist
function createToastContainer() {
    const toastContainer = document.createElement('div');
    toastContainer.id = 'toast-container';
    toastContainer.style.position = 'fixed';
    toastContainer.style.top = '20px';
    toastContainer.style.right = '20px';
    toastContainer.style.zIndex = '1000';
    document.body.appendChild(toastContainer);
    return toastContainer;
}
 */

function showToast(message) {
    const toastContainer = document.getElementById('toast-container') || createToastContainer();

    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast bg-blue-500 text-white py-2 px-4 rounded shadow-md mb-4 
        transform translate-x-full opacity-0 transition-all duration-200 ease-in-out`;
    toast.innerText = message;

    // Append toast to the container
    toastContainer.appendChild(toast);

    // Trigger enter animation
    setTimeout(() => {
        toast.classList.remove('translate-x-full', 'opacity-0');
        toast.classList.add('translate-x-0', 'opacity-100');
    }, 10); // Short delay to ensure the DOM processes the initial state

    // Automatically remove the toast after 3 seconds with an exit animation
    setTimeout(() => {
        toast.classList.remove('translate-x-0', 'opacity-100');
        toast.classList.add('translate-x-full', 'opacity-0');
        
        // Remove the toast after the exit transition completes
        toast.addEventListener('transitionend', () => {
            toast.remove();
        });
    }, 3000); // Duration to display the toast
}

// Helper to create the toast container if it doesn't exist
function createToastContainer() {
    const toastContainer = document.createElement('div');
    toastContainer.id = 'toast-container';
    toastContainer.style.position = 'fixed';
    toastContainer.style.top = '20px';
    toastContainer.style.right = '20px';
    toastContainer.style.zIndex = '1000';
    document.body.appendChild(toastContainer);
    return toastContainer;
}
