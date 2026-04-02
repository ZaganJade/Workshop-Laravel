{{-- Shared CSS for Tambah Barang pages --}}
<style>
    .tb-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }
    .tb-page-header h3 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }
    .tb-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-left: 12px;
        vertical-align: middle;
    }
    .tb-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        padding: 28px;
    }
    .tb-btn-add {
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        color: #fff;
        border: none;
        padding: 10px 22px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .tb-btn-add:hover {
        background: linear-gradient(135deg, #6d28d9, #5b21b6);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(124, 58, 237, 0.3);
    }

    /* Modal Styles */
    .tb-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.2s ease;
    }
    .tb-modal-overlay.active {
        display: flex;
    }
    .tb-modal {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        width: 100%;
        max-width: 480px;
        padding: 32px;
        transform: scale(0.95);
        opacity: 0;
        transition: all 0.25s ease;
    }
    .tb-modal-overlay.active .tb-modal {
        transform: scale(1);
        opacity: 1;
    }
    .tb-modal h4 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 24px;
    }
    .tb-modal label {
        display: block;
        font-weight: 600;
        margin-bottom: 6px;
        color: #374151;
        font-size: 0.9rem;
    }
    .tb-modal input {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        font-size: 0.95rem;
        outline: none;
        transition: border-color 0.2s;
        margin-bottom: 16px;
        box-sizing: border-box;
    }
    .tb-modal input:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }
    .tb-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 8px;
    }
    .tb-btn-cancel {
        padding: 10px 22px;
        border-radius: 8px;
        border: 1.5px solid #e0e0e0;
        background: #fff;
        color: #374151;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.95rem;
    }
    .tb-btn-cancel:hover {
        background: #f3f4f6;
    }
    .tb-btn-save {
        padding: 10px 22px;
        border-radius: 8px;
        border: none;
        background: linear-gradient(135deg, #10b981, #059669);
        color: #fff;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .tb-btn-save:hover {
        background: linear-gradient(135deg, #059669, #047857);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    .tb-btn-save:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    .tb-spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255,255,255,0.3);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .tb-nav-tabs {
        display: flex;
        gap: 8px;
        margin-bottom: 24px;
    }
    .tb-nav-tab {
        padding: 8px 20px;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s;
        border: 1.5px solid transparent;
    }
    .tb-nav-tab.active {
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        color: #fff;
        border-color: transparent;
    }
    .tb-nav-tab:not(.active) {
        background: #f5f3ff;
        color: #6d28d9;
        border-color: #e9d5ff;
    }
    .tb-nav-tab:not(.active):hover {
        background: #ede9fe;
    }
</style>
