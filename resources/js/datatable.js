document.addEventListener('DOMContentLoaded', () => {
    const tableContainers = document.querySelectorAll('.js-datatable-container');

    tableContainers.forEach(container => {
        const searchInput = container.querySelector('.js-search-input');
        const tbody = container.querySelector('tbody') || container.querySelector('.js-grid-body');
        if (!tbody) return;
        
        const rows = Array.from(tbody.children);
        const paginationContainer = container.querySelector('.js-pagination-controls');
        const defaultPerPage = parseInt(container.getAttribute('data-per-page')) || 10;
        let itemsPerPage = defaultPerPage;
        let currentPage = 1;
        let filteredRows = [...rows];

        // Ensure rows are displayed properly for tables vs grids
        const isGrid = tbody.tagName.toLowerCase() !== 'tbody';
        const displayType = isGrid ? '' : 'table-row';

        const renderTable = () => {
            // Hide all rows initially
            rows.forEach(row => {
                row.style.display = 'none';
                if (isGrid) row.classList.add('hidden');
            });

            // Show current page items
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            
            const paginatedItems = filteredRows.slice(startIndex, endIndex);
            paginatedItems.forEach(row => {
                if (isGrid) {
                    row.style.display = '';
                    row.classList.remove('hidden');
                } else {
                    row.style.display = displayType;
                }
            });

            renderPagination();
        };

        const renderPagination = () => {
            if (!paginationContainer) return;
            const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
            paginationContainer.innerHTML = '';

            // Main wrapper
            const wrapper = document.createElement('div');
            wrapper.className = 'flex flex-col sm:flex-row items-center justify-between w-full px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50/80 dark:bg-slate-800/50 gap-4';
            
            // Left side: Per-page selector + Info
            const leftGroup = document.createElement('div');
            leftGroup.className = 'flex items-center gap-4 flex-wrap';

            // Per-page selector
            const perPageWrapper = document.createElement('div');
            perPageWrapper.className = 'flex items-center gap-2';

            const perPageLabel = document.createElement('span');
            perPageLabel.className = 'text-sm text-gray-500 dark:text-gray-400 hidden sm:inline';
            perPageLabel.textContent = 'Tampilkan';

            const perPageSelect = document.createElement('select');
            perPageSelect.className = 'py-1.5 px-2.5 text-sm bg-white dark:bg-slate-700 border border-gray-200 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 focus:ring-2 focus:ring-blue-300 focus:border-blue-400 outline-none transition-all cursor-pointer appearance-none min-w-[70px] text-center font-medium shadow-sm';
            
            [10, 25, 50, 100].forEach(val => {
                const opt = document.createElement('option');
                opt.value = val;
                opt.textContent = val;
                if (val === itemsPerPage) opt.selected = true;
                perPageSelect.appendChild(opt);
            });

            perPageSelect.addEventListener('change', (e) => {
                itemsPerPage = parseInt(e.target.value);
                currentPage = 1;
                renderTable();
            });

            const perPageSuffix = document.createElement('span');
            perPageSuffix.className = 'text-sm text-gray-500 dark:text-gray-400 hidden sm:inline';
            perPageSuffix.textContent = 'data';

            perPageWrapper.appendChild(perPageLabel);
            perPageWrapper.appendChild(perPageSelect);
            perPageWrapper.appendChild(perPageSuffix);

            // Info text
            const info = document.createElement('span');
            info.className = 'text-sm text-gray-500 dark:text-gray-400';
            const start = filteredRows.length === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
            const end = Math.min(currentPage * itemsPerPage, filteredRows.length);
            info.innerHTML = `<span class="font-semibold text-gray-700 dark:text-gray-200">${start}-${end}</span> dari <span class="font-semibold text-gray-700 dark:text-gray-200">${filteredRows.length}</span> data`;

            leftGroup.appendChild(perPageWrapper);
            leftGroup.appendChild(info);

            // Right side: Page buttons
            const buttonGroup = document.createElement('div');
            buttonGroup.className = 'flex items-center gap-1';

            // Helper to create page buttons
            const createBtn = (text, disabled, onClick, isActive = false, isIcon = false) => {
                const btn = document.createElement('button');
                btn.innerHTML = text;
                btn.disabled = disabled;
                
                if (isActive) {
                    btn.className = 'w-9 h-9 flex items-center justify-center rounded-lg text-sm font-bold bg-blue-600 text-white shadow-md shadow-blue-500/30 transition-all';
                } else if (disabled) {
                    btn.className = `${isIcon ? 'w-9 h-9' : 'px-3 h-9'} flex items-center justify-center rounded-lg text-sm font-medium border border-gray-200 dark:border-gray-700 text-gray-300 dark:text-gray-600 cursor-not-allowed transition-all`;
                } else {
                    btn.className = `${isIcon ? 'w-9 h-9' : 'px-3 h-9'} flex items-center justify-center rounded-lg text-sm font-medium border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:border-blue-300 dark:hover:border-blue-500 hover:text-blue-600 dark:hover:text-blue-400 transition-all cursor-pointer`;
                }

                if (!disabled && onClick) btn.onclick = onClick;
                return btn;
            };

            // Previous button with icon
            const prevSvg = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>';
            buttonGroup.appendChild(createBtn(prevSvg, currentPage === 1, () => { currentPage--; renderTable(); }, false, true));

            // Page number buttons with ellipsis
            const maxVisiblePages = 5;
            let startPage, endPage;

            if (totalPages <= maxVisiblePages) {
                startPage = 1;
                endPage = totalPages;
            } else {
                const half = Math.floor(maxVisiblePages / 2);
                if (currentPage <= half + 1) {
                    startPage = 1;
                    endPage = maxVisiblePages;
                } else if (currentPage >= totalPages - half) {
                    startPage = totalPages - maxVisiblePages + 1;
                    endPage = totalPages;
                } else {
                    startPage = currentPage - half;
                    endPage = currentPage + half;
                }
            }

            if (startPage > 1) {
                buttonGroup.appendChild(createBtn('1', false, () => { currentPage = 1; renderTable(); }, currentPage === 1, true));
                if (startPage > 2) {
                    const dots = document.createElement('span');
                    dots.className = 'w-9 h-9 flex items-center justify-center text-gray-400 text-sm';
                    dots.textContent = '...';
                    buttonGroup.appendChild(dots);
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                buttonGroup.appendChild(createBtn(String(i), false, () => { currentPage = i; renderTable(); }, i === currentPage, true));
            }

            if (endPage < totalPages) {
                if (endPage < totalPages - 1) {
                    const dots = document.createElement('span');
                    dots.className = 'w-9 h-9 flex items-center justify-center text-gray-400 text-sm';
                    dots.textContent = '...';
                    buttonGroup.appendChild(dots);
                }
                buttonGroup.appendChild(createBtn(String(totalPages), false, () => { currentPage = totalPages; renderTable(); }, currentPage === totalPages, true));
            }

            // Next button with icon
            const nextSvg = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>';
            buttonGroup.appendChild(createBtn(nextSvg, currentPage === totalPages || totalPages === 0, () => { currentPage++; renderTable(); }, false, true));

            wrapper.appendChild(leftGroup);
            wrapper.appendChild(buttonGroup);
            paginationContainer.appendChild(wrapper);
        };

        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                const query = e.target.value.toLowerCase();
                filteredRows = rows.filter(row => {
                    return row.textContent.toLowerCase().includes(query);
                });
                currentPage = 1;
                renderTable();
            });
        }

        // Expose a method to add a new row programmatically to this container
        container.addNewRow = (newRowHtml) => {
            if(tbody.tagName.toLowerCase() === 'tbody') {
                const tempTable = document.createElement('table');
                tempTable.innerHTML = `<tbody>${newRowHtml}</tbody>`;
                const newTr = tempTable.querySelector('tr');
                tbody.prepend(newTr);
                rows.unshift(newTr);
            } else {
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = newRowHtml;
                const newCard = tempDiv.firstElementChild;
                tbody.prepend(newCard);
                rows.unshift(newCard);
            }
            
            filteredRows = [...rows];
            // Re-apply search if exists
            if(searchInput && searchInput.value) {
                searchInput.dispatchEvent(new Event('input'));
            } else {
                renderTable();
            }
        };

        // Initial render
        renderTable();
    });
});
