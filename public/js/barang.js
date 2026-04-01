
function openScopedModal(modalId) {
    const overlay = document.getElementById('scopedModalOverlay');
    const modal = document.getElementById(modalId);

    if (overlay && modal) {
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('scale-95', 'opacity-0');
            modal.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
}

function closeScopedModal(modalId) {
    const overlay = document.getElementById('scopedModalOverlay');
    const modal = document.getElementById(modalId);

    if (overlay && modal) {
        modal.classList.remove('scale-100', 'opacity-100');
        modal.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }, 300);
    }
}

// ================================
// DOM
// ================================
document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.barang-checkbox');
    const selectAll = document.getElementById('selectAll');
    const btnPrint = document.getElementById('btnPrintTnj');
    const btnPrintText = document.getElementById('btnPrintText');
    const hiddenIdsContainer = document.getElementById('hiddenIdsContainer');
    const selectedCountEl = document.getElementById('selectedCount');

    // TNJ Grid
    const tnjCells = document.querySelectorAll('.tnj-cell');
    const inputX = document.getElementById('inputX');
    const inputY = document.getElementById('inputY');
    const displayX = document.getElementById('displayX');
    const displayY = document.getElementById('displayY');
    const coordDisplay = document.getElementById('coordDisplay');

    let currentX = 1;
    let currentY = 1;

    // ================================
    // Checkbox Logic
    // ================================
    function updatePrintButton() {
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

    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            updatePrintButton();
            // Update select all state
            const total = checkboxes.length;
            const checked = document.querySelectorAll('.barang-checkbox:checked').length;
            selectAll.checked = checked === total;
            selectAll.indeterminate = checked > 0 && checked < total;
        });
    });

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            checkboxes.forEach(cb => {
                cb.checked = this.checked;
            });
            updatePrintButton();
        });
    }

    // ================================
    // Print Button -> Open Modal
    // ================================
    if (btnPrint) {
        btnPrint.addEventListener('click', function () {
            if (this.disabled) return;

            // Inject hidden inputs for selected IDs
            hiddenIdsContainer.innerHTML = '';
            const checked = document.querySelectorAll('.barang-checkbox:checked');
            checked.forEach(cb => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ids[]';
                input.value = cb.value;
                hiddenIdsContainer.appendChild(input);
            });

            // Reset grid highlight
            highlightGrid(currentX, currentY);

            openScopedModal('modalPrintTnj');
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

            // Reset
            cell.style.backgroundColor = '';
            cell.style.color = '#94a3b8';
            cell.querySelector('.cell-label').textContent = cellX + ',' + cellY;

            if (cellX === x && cellY === y) {
                // Selected starting cell
                cell.style.backgroundColor = '#059669';
                cell.style.color = '#ffffff';
                cell.style.fontWeight = '900';
                cell.querySelector('.cell-label').textContent = '▶ START';
            } else if (cellIndex >= startIndex && cellIndex < startIndex + itemCount) {
                // Filled cells 
                cell.style.backgroundColor = '#d1fae5';
                cell.style.color = '#065f46';
                cell.style.fontWeight = '700';

                const dataIndex = cellIndex - startIndex;
                if (dataIndex < itemCount) {
                    const nama = checkedItems[dataIndex].getAttribute('data-nama');
                    // Truncate long names
                    cell.querySelector('.cell-label').textContent = nama.length > 6 ? nama.substring(0, 5) + '…' : nama;
                }
            } else if (cellIndex < startIndex) {
                // Skipped cells (before start)
                cell.style.backgroundColor = '#f8fafc';
                cell.style.color = '#cbd5e1';
                cell.querySelector('.cell-label').textContent = '—';
            }
        });

        // Update displays
        inputX.value = x;
        inputY.value = y;
        displayX.textContent = x;
        displayY.textContent = y;
        coordDisplay.textContent = 'X:' + x + ' Y:' + y;
    }

    tnjCells.forEach(cell => {
        cell.addEventListener('click', function () {
            currentX = parseInt(this.getAttribute('data-x'));
            currentY = parseInt(this.getAttribute('data-y'));
            highlightGrid(currentX, currentY);
        });
    });

    // Initial highlight
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
});
