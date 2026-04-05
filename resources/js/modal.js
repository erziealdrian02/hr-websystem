// Modal Logic
document.addEventListener('DOMContentLoaded', () => {
    // Show Toast Function
    window.showToast = (title, message, isError = false) => {
        let toast = document.getElementById('global-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'global-toast';
            toast.className = 'fixed bottom-5 right-5 transform translate-y-20 opacity-0 bg-gray-900 text-white px-6 py-4 rounded-xl shadow-2xl transition-all duration-300 z-[100] flex items-center gap-3 border border-gray-700';
            document.body.appendChild(toast);
        }

        const iconColor = isError ? 'text-red-400' : 'text-green-400';
        const iconPath = isError ? 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z';
        
        toast.innerHTML = `
            <svg class="w-6 h-6 ${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${iconPath}"></path></svg>
            <div>
                <h4 class="font-bold text-sm">${title}</h4>
                ${message ? `<p class="text-xs text-gray-300">${message}</p>` : ''}
            </div>
        `;

        // Show
        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-20', 'opacity-0');
        });

        // Hide after 3 seconds
        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 3000);
    };

    // Open Modal Handling
    document.addEventListener('click', (e) => {
        const toggleBtn = e.target.closest('[data-modal-target]');
        if (toggleBtn) {
            const modalId = toggleBtn.getAttribute('data-modal-target');
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    modal.querySelector('.modal-overlay').classList.remove('opacity-0');
                    modal.querySelector('.modal-content').classList.remove('opacity-0', 'scale-95');
                }, 10);
            }
        }

        // Close Modal Handling
        const closeBtn = e.target.closest('[data-modal-close]');
        if (closeBtn) {
            const modal = closeBtn.closest('.modal-container');
            closeModal(modal);
        }
    });

    window.closeModal = (modal) => {
        if (!modal) return;
        modal.querySelector('.modal-overlay').classList.add('opacity-0');
        modal.querySelector('.modal-content').classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    };

    // Form Submission Simulation
    const forms = document.querySelectorAll('.js-simulated-form');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            const btn = form.querySelector('button[type="submit"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-3 inline" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...';
            btn.disabled = true;

            setTimeout(() => {
                // Success Simulation
                const modal = form.closest('.modal-container');
                closeModal(modal);
                showToast("Success", "Data has been successfully saved to the system.");
                
                // Call potential callback attached to the form
                if (typeof window[form.dataset.callback] === 'function') {
                    const formData = new FormData(form);
                    window[form.dataset.callback](formData);
                }

                // Reset form
                form.reset();
                btn.innerHTML = originalText;
                btn.disabled = false;
            }, 800); // simulate network delay
        });
    });
});
