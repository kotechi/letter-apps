import './bootstrap';
import Swal from 'sweetalert2';
window.Swal = Swal;

window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
});

// Custom Table Handler
class CustomTable {
    constructor(tableId, options = {}) {
        this.table = document.getElementById(tableId);
        if (!this.table) return;

        this.tbody = this.table.querySelector('tbody');
        this.thead = this.table.querySelector('thead');
        this.options = {
            itemsPerPage: options.itemsPerPage || 10,
            searchable: options.searchable !== false,
            sortable: options.sortable !== false,
            ...options
        };

        this.currentPage = 1;
        this.sortColumn = null;
        this.sortDirection = 'asc';
        this.searchTerm = '';
    this.allRows = Array.from(this.tbody.querySelectorAll('tr:not(.empty-state)'));
        
        this.init();
    }

    init() {
        this.createControls();
        this.attachSortListeners();
        this.render();
    }

    createControls() {
        const wrapper = document.createElement('div');
        wrapper.className = 'table-wrapper';
        this.table.parentNode.insertBefore(wrapper, this.table);
        wrapper.appendChild(this.table);

        // Top controls: two cards side-by-side like sample
        const topControls = document.createElement('div');
        topControls.className = 'flex flex-col md:flex-row justify-between items-start gap-4 mb-6';
        topControls.innerHTML = `
			<div class="w-full md:w-2/3 p-4 bg-white rounded-lg shadow-sm border">
				<div class="text-xs text-gray-500">Filter & Cari</div>
				<div class="mt-2">
					<form id="${this.table.id}-filterForm" class="flex gap-2 w-full">
						<input type="search" name="q" id="${this.table.id}-search" placeholder="Search..." 
							class="w-full border border-gray-300 p-2 rounded text-sm" />
						<button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700 transition text-sm">Cari</button>
					</form>
				</div>
			</div>

			<div class="w-full md:w-1/3 p-4 bg-white rounded-lg shadow-sm border flex flex-col justify-between">
				<div class="text-xs text-gray-500">Tampilan</div>
				<div class="mt-2 flex items-center gap-2">
					<label class="text-sm text-gray-600">Per halaman</label>
					<form id="${this.table.id}-perPageForm" class="m-0">
						<select id="${this.table.id}-perpage" name="per_page" class="border border-gray-300 p-2 rounded text-sm">
							<option value="10">10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
						</select>
					</form>
				</div>
			</div>
		`;
        wrapper.insertBefore(topControls, this.table);

        // Bottom controls (info + pagination)
        const bottomControls = document.createElement('div');
        bottomControls.className = 'flex flex-col md:flex-row justify-between items-center gap-4 mt-6';
        bottomControls.innerHTML = `
			<div id="${this.table.id}-info" class="text-sm text-gray-600 font-medium"></div>
			<div id="${this.table.id}-pagination" class="flex items-center gap-1"></div>
		`;
        wrapper.appendChild(bottomControls);

        // Attach event listeners
        const perPageSelect = document.getElementById(`${this.table.id}-perpage`);
        perPageSelect.value = this.options.itemsPerPage;
        perPageSelect.addEventListener('change', (e) => {
            this.options.itemsPerPage = parseInt(e.target.value);
            this.currentPage = 1;
            this.render();
        });

        // Search form: prevent real submit, use client-side filtering
        if (this.options.searchable) {
            const filterForm = document.getElementById(`${this.table.id}-filterForm`);
            const searchInput = document.getElementById(`${this.table.id}-search`);
            // Keep input event for instant feedback
            searchInput.addEventListener('input', (e) => {
                this.searchTerm = e.target.value.toLowerCase();
                this.currentPage = 1;
                this.render();
            });
            // Prevent default submit and apply same behavior
            filterForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.searchTerm = searchInput.value.toLowerCase();
                this.currentPage = 1;
                this.render();
            });
        }
    }

    attachSortListeners() {
        if (!this.options.sortable) return;

        const headers = this.thead.querySelectorAll('th[data-sortable="true"]');
        headers.forEach((th, index) => {
            th.classList.add('cursor-pointer', 'select-none', 'hover:bg-blue-100', 'transition-colors');
            th.innerHTML = `
                <div class="flex items-center justify-between gap-2">
                    <span>${th.textContent}</span>
                    <span class="sort-icon text-gray-400">
                        <i class="fas fa-sort"></i>
                    </span>
                </div>
            `;

            th.addEventListener('click', () => {
                if (this.sortColumn === index) {
                    this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                } else {
                    this.sortColumn = index;
                    this.sortDirection = 'asc';
                }
                this.updateSortIcons();
                this.sortData();
                this.render();
            });
        });
    }

    updateSortIcons() {
        const headers = this.thead.querySelectorAll('th[data-sortable="true"]');
        headers.forEach((th, index) => {
            const icon = th.querySelector('.sort-icon i');
            if (this.sortColumn === index) {
                icon.className = this.sortDirection === 'asc' ? 'fas fa-sort-up' : 'fas fa-sort-down';
                icon.parentElement.classList.remove('text-gray-400');
                icon.parentElement.classList.add('text-blue-600');
            } else {
                icon.className = 'fas fa-sort';
                icon.parentElement.classList.remove('text-blue-600');
                icon.parentElement.classList.add('text-gray-400');
            }
        });
    }

    sortData() {
        if (this.sortColumn === null) return;

        this.allRows.sort((a, b) => {
            const aVal = a.children[this.sortColumn]?.textContent.trim() || '';
            const bVal = b.children[this.sortColumn]?.textContent.trim() || '';

            // Try to parse as numbers
            const aNum = parseFloat(aVal.replace(/[^0-9.-]/g, ''));
            const bNum = parseFloat(bVal.replace(/[^0-9.-]/g, ''));

            if (!isNaN(aNum) && !isNaN(bNum)) {
                return this.sortDirection === 'asc' ? aNum - bNum : bNum - aNum;
            }

            // String comparison
            return this.sortDirection === 'asc' 
                ? aVal.localeCompare(bVal) 
                : bVal.localeCompare(aVal);
        });
    }

    getFilteredRows() {
        if (!this.searchTerm) return this.allRows;

        return this.allRows.filter(row => {
            const text = Array.from(row.children)
                .map(cell => cell.textContent.toLowerCase())
                .join(' ');
            return text.includes(this.searchTerm);
        });
    }

    render() {
        const filteredRows = this.getFilteredRows();
        const totalItems = filteredRows.length;
        const totalPages = Math.ceil(totalItems / this.options.itemsPerPage);
        
        // Adjust current page if needed
        if (this.currentPage > totalPages) {
            this.currentPage = Math.max(1, totalPages);
        }

        const startIndex = (this.currentPage - 1) * this.options.itemsPerPage;
        const endIndex = startIndex + this.options.itemsPerPage;
        const visibleRows = filteredRows.slice(startIndex, endIndex);

        // Clear tbody
        this.tbody.innerHTML = '';

        if (visibleRows.length === 0) {
            this.tbody.innerHTML = `
                <tr class="empty-state">
                    <td colspan="100" class="text-center py-12 text-gray-500">
                        <div class="text-4xl mb-3">📭</div>
                        <div class="text-lg font-medium">Tidak ada data ditemukan</div>
                        ${this.searchTerm ? '<div class="text-sm mt-1">Coba kata kunci lain</div>' : ''}
                    </td>
                </tr>
            `;
        } else {
            visibleRows.forEach(row => this.tbody.appendChild(row));
        }

        this.updateInfo(totalItems, startIndex, endIndex);
        this.updatePagination(totalPages);
    }

    updateInfo(total, start, end) {
        const infoDiv = document.getElementById(`${this.table.id}-info`);
        if (total === 0) {
            infoDiv.textContent = 'Tidak ada data';
        } else {
            const showing = Math.min(end, total);
            infoDiv.textContent = `Menampilkan ${start + 1} sampai ${showing} dari ${total} entri`;
        }
    }

    updatePagination(totalPages) {
        const paginationDiv = document.getElementById(`${this.table.id}-pagination`);
        if (totalPages <= 1) {
            paginationDiv.innerHTML = '';
            return;
        }

        let html = '';
        
        // Previous button
        html += `
            <button class="pagination-btn ${this.currentPage === 1 ? 'disabled' : ''}" 
                data-page="${this.currentPage - 1}" ${this.currentPage === 1 ? 'disabled' : ''}>
                <i class="fas fa-chevron-left"></i>
            </button>
        `;

        // Page numbers
        const maxVisible = 5;
        let startPage = Math.max(1, this.currentPage - Math.floor(maxVisible / 2));
        let endPage = Math.min(totalPages, startPage + maxVisible - 1);

        if (endPage - startPage < maxVisible - 1) {
            startPage = Math.max(1, endPage - maxVisible + 1);
        }

        if (startPage > 1) {
            html += `<button class="pagination-btn" data-page="1">1</button>`;
            if (startPage > 2) {
                html += `<span class="pagination-dots">...</span>`;
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            html += `
                <button class="pagination-btn ${i === this.currentPage ? 'active' : ''}" 
                    data-page="${i}">${i}</button>
            `;
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                html += `<span class="pagination-dots">...</span>`;
            }
            html += `<button class="pagination-btn" data-page="${totalPages}">${totalPages}</button>`;
        }

        // Next button
        html += `
            <button class="pagination-btn ${this.currentPage === totalPages ? 'disabled' : ''}" 
                data-page="${this.currentPage + 1}" ${this.currentPage === totalPages ? 'disabled' : ''}>
                <i class="fas fa-chevron-right"></i>
            </button>
        `;

        paginationDiv.innerHTML = html;

        // Attach click events
        paginationDiv.querySelectorAll('.pagination-btn:not(.disabled)').forEach(btn => {
            btn.addEventListener('click', () => {
                this.currentPage = parseInt(btn.dataset.page);
                this.render();
            });
        });
    }
}


// Export for use in other modules
window.CustomTable = CustomTable;