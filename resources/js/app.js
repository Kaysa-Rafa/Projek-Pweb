import './bootstrap';

// Hive Workshop custom JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Tooltips functionality
    const tooltipTriggers = document.querySelectorAll('[data-tooltip]');
    
    tooltipTriggers.forEach(trigger => {
        trigger.addEventListener('mouseenter', showTooltip);
        trigger.addEventListener('mouseleave', hideTooltip);
    });

    function showTooltip(e) {
        const tooltipText = this.getAttribute('data-tooltip');
        const tooltip = document.createElement('div');
        tooltip.className = 'absolute z-50 px-2 py-1 text-sm text-white bg-gray-900 rounded shadow-lg';
        tooltip.textContent = tooltipText;
        tooltip.id = 'tooltip';
        
        document.body.appendChild(tooltip);
        
        const rect = this.getBoundingClientRect();
        tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
    }

    function hideTooltip() {
        const tooltip = document.getElementById('tooltip');
        if (tooltip) {
            tooltip.remove();
        }
    }

    // File upload preview
    const fileInputs = document.querySelectorAll('input[type="file"][data-preview]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const previewId = this.getAttribute('data-preview');
            const preview = document.getElementById(previewId);
            const file = this.files[0];
            
            if (file && preview) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (file.type.startsWith('image/')) {
                        preview.innerHTML = `<img src="${e.target.result}" class="max-w-full h-auto rounded">`;
                    } else {
                        preview.innerHTML = `
                            <div class="text-center p-4 border-2 border-dashed border-gray-300 rounded">
                                <div class="text-gray-500">${file.name}</div>
                                <div class="text-sm text-gray-400">${(file.size / 1024 / 1024).toFixed(2)} MB</div>
                            </div>
                        `;
                    }
                };
                
                reader.readAsDataURL(file);
            }
        });
    });

    // Search functionality
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function(e) {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (window.Livewire) {
                    window.Livewire.find(this.closest('[wire\\:id]').getAttribute('wire:id'))
                        .set('search', this.value);
                }
            }, 300);
        });
    }
});

// Utility functions
window.HiveWorkshop = {
    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    },
    
    formatDate(date) {
        return new Date(date).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    }
};