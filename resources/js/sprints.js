document.querySelectorAll('.project-sprint').forEach((li) => {
    li.addEventListener('click', (event) => {
        window.location.href = event.currentTarget.getAttribute('data-sprint-url');
    })
})