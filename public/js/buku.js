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
    // Handle Buku Edit Modal Trigger
    const editButtons = document.querySelectorAll('.btn-edit-buku');
    const editForm = document.getElementById('formEditBuku');

    // Inputs
    const inputKode = document.getElementById('edit_kode');
    const inputJudul = document.getElementById('edit_judul');
    const inputPengarang = document.getElementById('edit_pengarang');
    const inputKategori = document.getElementById('edit_idkategori');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const kode = this.getAttribute('data-kode');
            const judul = this.getAttribute('data-judul');
            const pengarang = this.getAttribute('data-pengarang');
            const idkategori = this.getAttribute('data-idkategori');
            const updateUrl = this.getAttribute('data-url');

            // Populate fields
            if (editForm) editForm.action = updateUrl;
            if (inputKode) inputKode.value = kode;
            if (inputJudul) inputJudul.value = judul;
            if (inputPengarang) inputPengarang.value = pengarang;
            if (inputKategori) inputKategori.value = idkategori;

            // Open modal
            openScopedModal('modalEditBuku');
        });
    });

    // Close on overlay click
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
