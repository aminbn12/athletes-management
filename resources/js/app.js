import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
import { initSidebar } from './modules/sidebar.js';
import { initImagePreview } from './modules/modules/image-preview.js';
import { initConfirmDelete } from './modules/sweet-alert.js';

document.addEventListener('DOMContentLoaded', () => {
    // Initialisation des modules
    initSidebar();
    initImagePreview();
    initConfirmDelete();
    
    console.log('App initialized - Modular JS Architecture');
});