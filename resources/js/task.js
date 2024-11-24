console.log('task.js loaded');

document.querySelectorAll('.arrow-button').forEach(button => {
    button.addEventListener('click', function () {
        const url = this.getAttribute('data-url');
        console.log(url);
        console.log("click");
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    location.reload();
                } else {
                    alert(data.message || 'An error occurred.');
                }
            })
            .catch(error => console.error('Error:', error));
    });
});
