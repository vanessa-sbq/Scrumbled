import('./bootstrap');
if (!window.location.pathname.startsWith('/admin')) {
    import('./dropdown');
}

if (window.location.pathname === '/profiles' || window.location.pathname === '/admin/users') {
    import('./search');
}

