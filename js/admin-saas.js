document.addEventListener('DOMContentLoaded', function() {
    // Sidebar Toggle (Mobile & Desktop)
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const adminSidebar  = document.getElementById('admin-sidebar');
    const sidebarOverlay = document.getElementById('sidebar-overlay');

    if (sidebarToggle && adminSidebar) {
        sidebarToggle.addEventListener('click', function () {
            // Desktop: collapse sidebar
            if (window.innerWidth >= 992) {
                adminSidebar.classList.toggle('collapsed');
            }
            // Mobile: slide-in
            else {
                adminSidebar.classList.toggle('show');
                if (sidebarOverlay) sidebarOverlay.classList.toggle('show');
            }
        });
    }

    if (sidebarOverlay && adminSidebar) {
        sidebarOverlay.addEventListener('click', function () {
            adminSidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });
    }

    // Initialize Bootstrap Tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    if (typeof bootstrap !== 'undefined') {
        tooltipTriggerList.forEach(function (el) {
            new bootstrap.Tooltip(el);
        });
    }
});
