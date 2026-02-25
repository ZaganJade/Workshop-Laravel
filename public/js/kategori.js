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

document.addEventListener('DOMContentLoaded', function () {
    // Handle Kategori Edit Modal Trigger
    const editButtons = document.querySelectorAll('.btn-edit-kategori');
    const editForm = document.getElementById('formEditKategori');
    const editInput = document.getElementById('edit_nama_kategori');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const name = this.getAttribute('data-name');
            const updateUrl = this.getAttribute('data-url');

            // Populate fields
            if (editForm) editForm.action = updateUrl;
            if (editInput) editInput.value = name;

            // Open modal
            openScopedModal('modalEditKategori');
        });
    });

    // Close on overlay click (if clicking precisely on the overlay background)
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
