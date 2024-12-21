document.addEventListener("DOMContentLoaded", () => {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const commentForm = document.getElementById('commentForm');

    // Toggle Comment Form
    if (document.getElementById('addComment')) {
        document.getElementById('addComment').addEventListener('click', () => {
            commentForm.classList.toggle('hidden');
        });
    }

    // Add Comment
    document.getElementById('submit-comment').addEventListener('click', () => {
        const description = document.getElementById('new-comment-description').value.trim();
        const createCommentUrl = document.querySelector('section[data-create-comment-url]').dataset.createCommentUrl;

        if (!description || description.length > 1000) {
            alert('Comment must not be empty and cannot exceed 1000 characters.');
            return;
        }

        fetch(createCommentUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({ description }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    addCommentToUI(data.html); // Server should return rendered HTML
                    document.getElementById('new-comment-description').value = '';
                    commentForm.classList.add('hidden');
                } else {
                    alert('Failed to add comment.');
                }
            })
            .catch(error => {
                console.error("Error adding comment:", error);
                alert('An unexpected error occurred. Please try again.');
            });
    });

    function saveComment(e) {
        const commentId = e.target.getAttribute('data-id');
        const description = document.getElementById(`description-${commentId}`).value.trim();
        const editCommentUrl = `/comments/${commentId}/edit`

        fetch(editCommentUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({ description }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`comment-text-${commentId}`).textContent = data.comment.description;
                    toggleEditForm(commentId, false);
                } else {
                    alert(`Error while editing comment: ${data.message}`);
                }
            })
            .catch(error => {
                console.error("Error editing comment:", error);
                alert('An unexpected error occurred. Please try again.');
            });
    }

    // Edit Comment
    document.querySelectorAll('.save-edit-comment-button').forEach( (button) => {
        button.addEventListener('click', saveComment);
    })

    document.querySelectorAll('.edit-comment-button').forEach( (button) => {
        button.addEventListener('click', (e) => {
                const commentId = e.target.getAttribute('data-id');
                toggleEditForm(commentId, true);
        });
    })

    // Delete Comment
    document.querySelectorAll('.delete-comment-buttton').forEach( (button) => {
        button.addEventListener('click', (e) => {
            const commentId = e.target.getAttribute('data-id');
            const deleteCommentUrl = e.target.closest('div').dataset.deleteCommentUrl;

            if (!confirm('Are you sure you want to delete this comment?')) return;

            fetch(deleteCommentUrl, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`comment-${commentId}`).remove();
                    } else {
                        alert('Failed to delete comment.');
                    }
                })
                .catch(error => {
                    console.error("Error deleting comment:", error);
                    alert('An unexpected error occurred. Please try again.');
                });
        });
    })

    // Toggle Edit Form
    function toggleEditForm(commentId, show) {
        const editForm = document.getElementById(`edit-form-${commentId}`);
        const commentText = document.getElementById(`comment-text-${commentId}`);
        const textarea = document.getElementById(`description-${commentId}`);

        if (show) {
            textarea.value = commentText.textContent.trim();
            editForm.classList.remove('hidden');
            commentText.classList.add('hidden');
        } else {
            editForm.classList.add('hidden');
            commentText.classList.remove('hidden');
        }
    }

    // Add Comment to UI
    function addCommentToUI(html) {
        const commentsContainer = document.querySelector('.space-y-4');
        commentsContainer.insertAdjacentHTML('beforeend', html);

        const newComment = commentsContainer.lastElementChild;
        const editButton = newComment.querySelector('.edit-comment');
        const deleteButton = newComment.querySelector('.delete-comment');
        const saveButton = newComment.querySelector('.save-edit-comment-button');

        saveButton.addEventListener('click', saveComment);

        editButton.addEventListener('click', () => {
            const commentId = editButton.getAttribute('data-id');
            toggleEditForm(commentId, true);
        });

        deleteButton.addEventListener('click', () => {
            const commentId = deleteButton.getAttribute('data-id');
            const deleteCommentUrl = deleteButton.closest('div').dataset.deleteCommentUrl;

            if (!confirm('Are you sure you want to delete this comment?')) return;

            fetch(deleteCommentUrl, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`comment-${commentId}`).remove();
                    } else {
                        alert('Failed to delete comment.');
                    }
                });
        });
    }
});