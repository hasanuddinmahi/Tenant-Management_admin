document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const body = document.body;

    function isMobile() {
        return window.innerWidth <= 768;
    }

    function openSidebar() {
        if (isMobile()) {
            sidebar.classList.add('sidebar-open');
            body.classList.add('sidebar-open');
        } else {
            sidebar.classList.toggle('sidebar-collapsed');
        }
        sidebar.classList.add('sidebar-manual-toggle');
    }

    function closeSidebar() {
        if (isMobile()) {
            sidebar.classList.remove('sidebar-open');
            body.classList.remove('sidebar-open');
        }
    }

    sidebarToggle.addEventListener('click', function () {
        if (isMobile()) {
            sidebar.classList.contains('sidebar-open') ? closeSidebar() : openSidebar();
        } else {
            sidebar.classList.toggle('sidebar-collapsed');
            sidebar.classList.add('sidebar-manual-toggle');
        }
    });

    sidebarOverlay.addEventListener('click', closeSidebar);

    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
        link.addEventListener('click', () => {
            if (isMobile()) closeSidebar();
        });
    });

    window.addEventListener('resize', function () {
        if (!sidebar.classList.contains('sidebar-manual-toggle')) {
            if (isMobile()) {
                closeSidebar();
                sidebar.classList.add('sidebar-collapsed');
            } else {
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.remove('sidebar-open');
                body.classList.remove('sidebar-open');
            }
        }
        if (!isMobile()) {
            sidebar.classList.remove('sidebar-manual-toggle');
        }
    });

    if (isMobile()) {
        sidebar.classList.add('sidebar-collapsed');
    }
});
