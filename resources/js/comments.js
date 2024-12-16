document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('addComment');
    const commentForm = document.getElementById('commentForm');

    toggleButton.addEventListener('click', function () {
        commentForm.classList.toggle('hidden');

        if (!commentForm.classList.contains('hidden')) {
            const textarea = commentForm.querySelector('textarea');
            textarea.focus();
        }
    });
});