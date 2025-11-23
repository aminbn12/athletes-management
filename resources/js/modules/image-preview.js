export function initImagePreview() {
    const fileInputs = document.querySelectorAll('input[type="file"][data-preview]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const targetId = this.dataset.preview;
            const previewEl = document.getElementById(targetId);
            
            if (previewEl && this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewEl.src = e.target.result;
                    previewEl.classList.remove('hidden');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
}