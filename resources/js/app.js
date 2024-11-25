import('./bootstrap');
if (!window.location.pathname.startsWith('/admin')) {
    import('./dropdown');
}

if (window.location.pathname === '/profiles' || window.location.pathname === '/admin/users') {
    import('./search');
}

const pathMatch = window.location.pathname.match(/\^\/projects\/([\^\/]+)\/tasks$/);
console.log(pathMatch);
if (pathMatch) {
    const slug = pathMatch[1];
    console.log('Loading taskSearch.js for slug:', slug); // Debugging log
    import('./taskSearch');
}

import('./task')