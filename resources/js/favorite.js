function toggleFavorite(favoriteButton, newState, url) {
    const icon = favoriteButton.querySelector('svg');

    if (newState === 'Favorited') {
        icon.classList.remove('text-gray-400');
        icon.classList.add('text-yellow-400');
    } else {
        icon.classList.remove('text-yellow-400');
        icon.classList.add('text-gray-400');
    }

    favoriteButton.setAttribute('data-state', newState);
    favoriteButton.setAttribute('data-url', url);
}

function handleFavoriteChange(event) {
    const favoriteButton = event.currentTarget;
    const currentState = favoriteButton.getAttribute('data-state');
    const newState = currentState === 'Favorited' ? 'Unfavorited' : 'Favorited';
    const url = favoriteButton.getAttribute('data-url');

    toggleFavorite(favoriteButton, newState, url);

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ state: newState })
    })
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'success') {
                // Revert UI if the server responds with an error
                alert(data.message || 'An error occurred. Please try again.');
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error updating favorite state:', error);
            alert('An unexpected error occurred. Please try again.');
            location.reload();
        });
}

document.querySelectorAll('.favorite-button').forEach(button => {
    button.addEventListener('click', handleFavoriteChange);
});