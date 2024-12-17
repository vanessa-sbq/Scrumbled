document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('addComment');
    const commentForm = document.getElementById('commentForm');

    // Toggle the visibility of the comment form when the 'Add Comment' button is clicked
    toggleButton.addEventListener('click', function () {
        commentForm.classList.toggle('hidden');

        if (!commentForm.classList.contains('hidden')) {
            const textarea = commentForm.querySelector('textarea');
            textarea.focus();
        }
    });
});

// Function to handle showing the edit form and hiding the current comment text
function editComment(commentId) {
    const commentText = document.getElementById(`comment-text-${commentId}`);
    const editForm = document.getElementById(`edit-form-${commentId}`);

    // Check if both elements are present before toggling visibility
    if (commentText && editForm) {
        commentText.style.display = 'none';  // Hide the current comment text
        editForm.style.display = 'block';    // Show the edit form
    }
}

// Function to handle canceling the edit
function cancelEdit(commentId) {
    const commentText = document.getElementById(`comment-text-${commentId}`);
    const editForm = document.getElementById(`edit-form-${commentId}`);

    // Ensure the form is hidden and text is visible when editing is canceled
    if (commentText && editForm) {
        commentText.style.display = 'block'; // Show the original comment text
        editForm.style.display = 'none';     // Hide the edit form
    }
}
