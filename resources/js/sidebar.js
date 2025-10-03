document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const body = document.body;

    if (window.innerWidth <= 768) {
        sidebar.classList.add('sidebar-hidden');
    }

    if (window.innerWidth > 768) {
        sidebar.classList.remove('sidebar-hidden');
    }

    sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('sidebar-hidden');
    });

    body.addEventListener('click', function(event) {
        if (window.innerWidth <= 767.98 && !sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
            sidebar.classList.add('sidebar-hidden');
        }
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('sidebar-hidden');
        }
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth <= 768) {
            sidebar.classList.add('sidebar-hidden');
        }
    });

    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
});