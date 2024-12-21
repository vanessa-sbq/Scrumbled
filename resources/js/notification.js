document.addEventListener('DOMContentLoaded', () => {
    const notificationData = document.getElementById('toast-container');
    const userId = notificationData.dataset.userId; 
    const toastMessage = notificationData.dataset.toastMessage; 
    const audioPath = notificationData.dataset.audio;

    // Pusher Setup
    Pusher.logToConsole = true;

    const pusher = new Pusher('03b9124b3ce439d7ba7d', {
        cluster: 'eu',
        encrypted: true
    });

    // Subscribe to the notifications channel
    const channel = pusher.subscribe(`user.${userId}`);

    // Listen for new notification events
    channel.bind('new-notification', function(data) {
        playAudio();
        showToast(data.message);
        if (data.message == 'You received an invitation!' || data.message.endsWith('accepted your invitation!')) {
            showNotificationDot();
        }
    });

    // Show the blue dot
    function playAudio() {
        let audio = new Audio(audioPath);
        audio.play();
    }

    function showNotificationDot(){
        const notificationDot = document.getElementById('notification-dot');
        const pfpDot = document.getElementById('pfp-dot');
        notificationDot.classList.remove('hidden');
        pfpDot.classList.remove('hidden');
    }

    if (toastMessage) {
        if (!sessionStorage.getItem('toastShown')) {
            showToast(toastMessage);
            sessionStorage.setItem('toastShown', 'true');
            
        }
    }
});