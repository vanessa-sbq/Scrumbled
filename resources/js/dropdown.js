const dropdownButton = document.getElementById('dropdown-trigger');
const dropdownMenu = document.getElementById('dropdown-menu');

if (dropdownButton) {
    // Toggle the dropdown visibility when the button is clicked
    dropdownButton.addEventListener('click', function (event) {
        event.preventDefault();

        // Toggle the "hidden" class and trigger transition
        if (dropdownMenu.classList.contains('hidden')) {
            dropdownMenu.classList.remove('hidden');
            // Force reflow to enable transition
            dropdownMenu.offsetHeight; // This triggers a reflow
            dropdownMenu.classList.remove('opacity-0', 'scale-95');
            dropdownMenu.classList.add('opacity-100', 'scale-100');  // Transition to visible state
        } else {
            dropdownMenu.classList.remove('opacity-100', 'scale-100');  // Transition to hidden state
            dropdownMenu.classList.add('opacity-0', 'scale-95'); // Hide with animation
            setTimeout(() => {
                dropdownMenu.classList.add('hidden'); // Ensure the menu is fully hidden after animation
            }, 200); // Match duration of leaving transition
        }
    });

    // Close the dropdown if the user clicks outside of it
    document.addEventListener('click', function (event) {
        if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            setTimeout(() => {
                dropdownMenu.classList.add('hidden');
            }, 200);
        }
    });
}