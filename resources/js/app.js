import './bootstrap';

import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css'; // Import the default styling

// Initialize tooltips after the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    tippy('[data-tippy-content]', {
        // Global tippy options
        placement: 'top', // Default placement
        arrow: true,
        animation: 'fade',
        theme: 'custom' // We'll define this theme below
    });
});
