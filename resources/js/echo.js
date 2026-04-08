import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    // Fallback explicit untuk CI/CD (aman karena public key)
    key: import.meta.env.VITE_PUSHER_APP_KEY || '9b9afe656427a60dc2f0',
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER || 'ap1',
    wsHost: `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER || 'ap1'}.pusher.com`,
    wsPort: 80,
    wssPort: 443,
    forceTLS: true,
    enabledTransports: ['ws', 'wss'],
});
