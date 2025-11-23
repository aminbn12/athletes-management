export function initSidebar() {
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('w-20');
            sidebar.classList.toggle('w-64');
            
            // Masquer/Afficher les textes
            document.querySelectorAll('.sidebar-text').forEach(el => {
                el.classList.toggle('hidden');
            });
        });
    }
}