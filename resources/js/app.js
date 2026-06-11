import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'datatables.net-bs5/js/dataTables.bootstrap5.min.js';
import 'datatables.net-bs5';

// DataTable default config
$.fn.dataTable.defaults = {
    language: {
        url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
    }
};

// Dark mode toggle
window.toggleDarkMode = function() {
    document.body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
};

// Load dark mode preference
if(localStorage.getItem('darkMode') === 'true') {
    document.body.classList.add('dark-mode');
}

// Sidebar toggle
window.toggleSidebar = function() {
    document.querySelector('.sidebar').classList.toggle('active');
};