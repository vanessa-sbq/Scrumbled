<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusher Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">
  <h1 class="text-2xl font-bold mb-4">Pusher Test</h1>
  <p class="text-gray-700 mb-8">
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>form-submitted</code>.
  </p>

  <!-- Toast container -->
  <div id="toast-container" class="fixed top-4 right-4 flex flex-col items-end z-50"></div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Pusher setup
      Pusher.logToConsole = true;

      const pusher = new Pusher('03b9124b3ce439d7ba7d', {
        cluster: 'eu'
      });

      const channel = pusher.subscribe('my-channel');
      channel.bind('form-submitted', function(data) {
        showToast(JSON.stringify(data));
      });

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
    });
  </script>
</body>
</html>
