
function openScopedModal(modalId) {
    const overlay = document.getElementById('scopedModalOverlay');
    const modalEl = document.getElementById(modalId);

    if (overlay && modalEl) {
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');

        modalEl.classList.remove('hidden');
        setTimeout(() => {
            modalEl.classList.remove('scale-95', 'opacity-0');
            modalEl.classList.add('scale-100', 'opacity-100');
        }, 10);
    } else if (modalEl && typeof bootstrap !== 'undefined') {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }
}

function closeScopedModal(modalId) {
    const overlay = document.getElementById('scopedModalOverlay');
    const modalEl = document.getElementById(modalId);

    if (overlay && modalEl) {
        modalEl.classList.remove('scale-100', 'opacity-100');
        modalEl.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modalEl.classList.add('hidden');
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }, 300);
    } else if (modalEl && typeof bootstrap !== 'undefined') {
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) {
            modal.hide();
        } else {
            // Force hide if no instance
            modalEl.classList.add('hidden');
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
        }
    }
}

// ================================
// CRUD Data Storage
// ================================
let dataBarang = [];
let editIndex = -1;
let autoIdCounter = 0;

function generateId() {
    autoIdCounter++;
    return 'BRG' + String(autoIdCounter).padStart(5, '0');
}

function formatRupiah(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

// ================================
// Render Table
// ================================
function renderTable() {
    const tbody = document.getElementById('barangTableBody');
    if (!tbody) return;

    // Keep server-rendered rows (they have class 'server-row')
    // Remove only JS-added rows (they have class 'js-row')
    tbody.querySelectorAll('.js-row').forEach(row => row.remove());

    // Append JS dataBarang rows
    dataBarang.forEach((item, index) => {
        const tr = document.createElement('tr');
        tr.className = 'group hover:bg-slate-50/70 transition-all duration-300 barang-row js-row cursor-pointer';
        tr.setAttribute('data-crud-index', index);
        tr.innerHTML = `
            <td class="px-8 py-5 text-center">
                <input type="checkbox" class="barang-checkbox w-5 h-5 rounded-lg border-2 border-slate-200 text-emerald-500 focus:ring-emerald-400 focus:ring-offset-0 cursor-pointer accent-emerald-500"
                       value="${item.id}" data-nama="${item.nama}" data-harga="${item.harga}">
            </td>
            <td class="px-10 py-5">
                <span class="px-4 py-1.5 bg-slate-900 text-white text-[11px] font-black rounded-lg border border-slate-700 uppercase tracking-widest shadow-lg shadow-slate-200">
                    ${item.id}
                </span>
            </td>
            <td class="px-10 py-5">
                <div class="text-lg font-black text-slate-800 tracking-tight group-hover:text-emerald-600 transition-colors">${item.nama}</div>
            </td>
            <td class="px-10 py-5">
                <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[12px] font-black bg-emerald-50 text-emerald-700 border border-emerald-100 tracking-wide">
                    Rp ${formatRupiah(item.harga)}
                </span>
            </td>
        `;

        // Row click -> open edit (but not on checkbox)
        tr.addEventListener('click', function (e) {
            if (e.target.tagName === 'INPUT') return;
            editIndex = index;
            document.getElementById('edit_id').value = item.id;
            document.getElementById('edit_nama').value = item.nama;
            document.getElementById('edit_harga').value = item.harga;
            if (typeof openModal === 'function') {
                openModal('modalEditBarang');
            } else {
                openScopedModal('modalEditBarang');
            }
        });

        tbody.appendChild(tr);
    });

    // Re-bind listeners (using delegation now, so no action needed here, but update count)
    updateItemCount();
    updatePrintButton();
}

// ================================
// Item Count Badge
// ================================
function updateItemCount() {
    const badge = document.getElementById('itemCountBadge');
    if (!badge) return;
    const serverRows = document.querySelectorAll('#barangTableBody tr:not(.js-row)').length;
    const total = serverRows + dataBarang.length;
    badge.textContent = total + ' Item Terdaftar';
}

// ================================
// Simpan Barang (CREATE)
// ================================
function simpanBarang() {
    const form = document.getElementById('formTambahBarang');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const nama = document.getElementById('tambah_nama').value.trim();
    const harga = parseInt(document.getElementById('tambah_harga').value);

    if (!nama || isNaN(harga)) return;

    // Loading state
    const btn = document.getElementById('btnSimpanBarang');
    const spinner = document.getElementById('spinnerSimpan');
    const txt = document.getElementById('txtSimpan');
    btn.disabled = true;
    spinner.classList.remove('hidden');
    txt.textContent = 'Menyimpan...';

    setTimeout(() => {
        dataBarang.push({
            id: generateId(),
            nama: nama,
            harga: harga
        });

        renderTable();

        // Reset form
        document.getElementById('tambah_nama').value = '';
        document.getElementById('tambah_harga').value = '';

        // Reset button
        btn.disabled = false;
        spinner.classList.add('hidden');
        txt.textContent = 'Simpan';

        closeScopedModal('modalTambahBarang');
    }, 400);
}

function ubahBarang() {
    const form = document.getElementById('formEditBarang');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    if (editIndex < 0 || editIndex >= dataBarang.length) return;

    const nama = document.getElementById('edit_nama').value.trim();
    const harga = parseInt(document.getElementById('edit_harga').value);

    if (!nama || isNaN(harga)) return;

    // Loading state
    const btn = document.getElementById('btnUbahBarang');
    const spinner = document.getElementById('spinnerUbah');
    const txt = document.getElementById('txtUbah');
    btn.disabled = true;
    spinner.classList.remove('hidden');
    txt.textContent = 'Mengubah...';

    setTimeout(() => {
        dataBarang[editIndex].nama = nama;
        dataBarang[editIndex].harga = harga;

        renderTable();

        btn.disabled = false;
        spinner.classList.add('hidden');
        txt.textContent = 'Ubah';

        closeScopedModal('modalEditBarang');
        editIndex = -1;
    }, 400);
}

// ================================
// Hapus Barang (DELETE)
// ================================
function hapusBarang() {
    if (editIndex < 0 || editIndex >= dataBarang.length) return;

    if (!confirm('Apakah Anda yakin ingin menghapus barang ini?')) return;

    dataBarang.splice(editIndex, 1);
    renderTable();
    closeScopedModal('modalEditBarang');
    editIndex = -1;
}

// ================================
// DOM Ready
// ================================
document.addEventListener('DOMContentLoaded', function () {

    // TNJ Grid elements
    const tnjCells = document.querySelectorAll('.tnj-cell');
    const inputX = document.getElementById('inputX');
    const inputY = document.getElementById('inputY');
    const displayX = document.getElementById('displayX');
    const displayY = document.getElementById('displayY');
    const coordDisplay = document.getElementById('coordDisplay');

    let currentX = 1;
    let currentY = 1;

    const tableBody = document.getElementById('barangTableBody');
    if (tableBody) {
        tableBody.addEventListener('change', function (e) {
            if (e.target.classList.contains('barang-checkbox')) {
                updatePrintButton();
                
                const allCbs = tableBody.querySelectorAll('.barang-checkbox');
                const checkedCount = tableBody.querySelectorAll('.barang-checkbox:checked').length;
                const selectAll = document.getElementById('selectAll');
                if (selectAll) {
                    selectAll.checked = checkedCount > 0 && checkedCount === allCbs.length;
                    selectAll.indeterminate = checkedCount > 0 && checkedCount < allCbs.length;
                }
            }
        });
    }

    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            const allCbs = document.querySelectorAll('.barang-checkbox');
            allCbs.forEach(cb => {
                cb.checked = this.checked;
            });
            updatePrintButton();
        });
    }

    // ================================
    // Print Button -> Open Modal
    // ================================
    const btnPrint = document.getElementById('btnPrintTnj');
    if (btnPrint) {
        btnPrint.addEventListener('click', function () {
            if (this.disabled) return;

            const hiddenIdsContainer = document.getElementById('hiddenIdsContainer');
            hiddenIdsContainer.innerHTML = '';
            const checked = document.querySelectorAll('.barang-checkbox:checked');
            checked.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                hiddenIdsContainer.appendChild(input);
            });

            highlightGrid(currentX, currentY);
            if (typeof openModal === 'function') {
                openModal('modalPrintTnj');
            } else {
                openScopedModal('modalPrintTnj');
            }
        });
    }

    // ================================
    // TNJ Grid Click Logic
    // ================================
    function highlightGrid(x, y) {
        const startIndex = (y - 1) * 5 + (x - 1);
        const checkedItems = document.querySelectorAll('.barang-checkbox:checked');
        const itemCount = checkedItems.length;

        tnjCells.forEach(cell => {
            const cellX = parseInt(cell.getAttribute('data-x'));
            const cellY = parseInt(cell.getAttribute('data-y'));
            const cellIndex = (cellY - 1) * 5 + (cellX - 1);

            cell.style.backgroundColor = '';
            cell.style.color = '#94a3b8';
            cell.style.fontWeight = '';
            const label = cell.querySelector('.cell-label');
            if (label) label.textContent = cellX + ',' + cellY;

            if (cellX === x && cellY === y) {
                cell.style.backgroundColor = '#059669';
                cell.style.color = '#ffffff';
                cell.style.fontWeight = '900';
                const label = cell.querySelector('.cell-label');
                if (label) label.textContent = '▶ START';
            } else if (cellIndex >= startIndex && cellIndex < startIndex + itemCount) {
                cell.style.backgroundColor = '#d1fae5';
                cell.style.color = '#065f46';
                cell.style.fontWeight = '700';

                const dataIndex = cellIndex - startIndex;
                if (dataIndex < itemCount) {
                    const nama = checkedItems[dataIndex].getAttribute('data-nama');
                    const label = cell.querySelector('.cell-label');
                    if (label) label.textContent = nama.length > 6 ? nama.substring(0, 5) + '…' : nama;
                }
            } else if (cellIndex < startIndex) {
                cell.style.backgroundColor = '#f8fafc';
                cell.style.color = '#cbd5e1';
                const label = cell.querySelector('.cell-label');
                if (label) label.textContent = '—';
            }
        });

        if (inputX) inputX.value = x;
        if (inputY) inputY.value = y;
        if (displayX) displayX.textContent = x;
        if (displayY) displayY.textContent = y;
        if (coordDisplay) coordDisplay.textContent = 'X:' + x + ' Y:' + y;
    }

    tnjCells.forEach(cell => {
        cell.addEventListener('click', function () {
            currentX = parseInt(this.getAttribute('data-x'));
            currentY = parseInt(this.getAttribute('data-y'));
            highlightGrid(currentX, currentY);
        });
    });

    highlightGrid(1, 1);

    // ================================
    // Close on overlay click
    // ================================
    const overlay = document.getElementById('scopedModalOverlay');
    if (overlay) {
        overlay.addEventListener('click', function (e) {
            if (e.target === this) {
                const visibleModal = this.querySelector('div[id^="modal"]:not(.hidden)');
                if (visibleModal) {
                    closeScopedModal(visibleModal.id);
                }
            }
        });
    }

    // ================================
    // Server-rendered rows: click -> edit (server rows are NOT editable via JS CRUD, only JS rows are)
    // ================================
    // No action needed — server rows are read-only in this context.

    // Init item count
    updateItemCount();
});

// ================================
// Checkbox Rebind Helper
// ================================
// ================================
// Checkbox delegation logic is now handled in DOMContentLoaded
// ================================

function updatePrintButton() {
    const btnPrint = document.getElementById('btnPrintTnj');
    const btnPrintText = document.getElementById('btnPrintText');
    const selectedCountEl = document.getElementById('selectedCount');
    const checked = document.querySelectorAll('.barang-checkbox:checked');
    const count = checked.length;

    if (count > 0) {
        btnPrint.disabled = false;
        btnPrintText.textContent = `Print Label TNJ (${count})`;
    } else {
        btnPrint.disabled = true;
        btnPrintText.textContent = 'Print Label TNJ';
    }

    if (selectedCountEl) {
        selectedCountEl.textContent = count + ' barang';
    }
}
