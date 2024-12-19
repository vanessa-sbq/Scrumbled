function showToast(message) {
    const toastContainer = document.getElementById('toast-container');

    const toast = document.createElement('div');
    toast.className = `toast bg-blue-500 text-white py-2 px-4 rounded shadow-md mb-4 translate-x-full opacity-0 transition-transform duration-2000 ease-in-out`;
    toast.innerText = message;

    toastContainer.appendChild(toast);

    // Trigger enter animation
    requestAnimationFrame(() => {
    toast.classList.remove('translate-x-full', 'opacity-0');
    toast.classList.add('translate-x-0', 'opacity-100');
    });

    // Automatically remove the toast after 3 seconds
    setTimeout(() => {
    toast.classList.remove('translate-x-0', 'opacity-100');
    toast.classList.add('translate-x-full', 'opacity-0');
    setTimeout(() => {
        toast.remove();
    }, 2000);
    }, 3000);
}