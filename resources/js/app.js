import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Utility Functions
window.confirmDelete = function(message = 'Are you sure?') {
    return confirm(message);
};

window.showAlert = function(message, type = 'info') {
    const alertDiv = document.createElement('div');
    const colors = {
        success: 'bg-green-50 text-green-800 border-green-200',
        error: 'bg-red-50 text-red-800 border-red-200',
        info: 'bg-blue-50 text-blue-800 border-blue-200',
        warning: 'bg-blue-50 text-blue-800 border-blue-200',
    };
    
    alertDiv.className = `p-4 rounded-lg border ${colors[type] || colors.info} fade-in`;
    alertDiv.textContent = message;
    
    document.body.insertBefore(alertDiv, document.body.firstChild);
    
    setTimeout(() => alertDiv.remove(), 5000);
};

// Charts Initialization
window.initChart = function(canvasId, config) {
    const ctx = document.getElementById(canvasId);
    if (ctx) {
        new window.Chart(ctx, config);
    }
};