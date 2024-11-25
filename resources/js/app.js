import('./bootstrap');

if (!window.location.pathname.startsWith('/admin')) {
    import('./dropdown');
}

if (window.location.pathname === '/profiles' || window.location.pathname === '/admin/users') {
    import('./search');
}

if (window.location.pathname === '/tasks') {
    import('./taskSearch');
}

import('./task')