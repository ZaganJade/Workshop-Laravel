{{-- CSS khusus HTML Table --}}
<style>
    .tb-badge {
        background: #dbeafe;
        color: #1d4ed8;
    }
    .tb-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 20px;
    }
    .tb-table thead th {
        background: linear-gradient(135deg, #7c3aed, #6d28d9);
        color: #fff;
        padding: 14px 18px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .tb-table thead th:first-child {
        border-radius: 8px 0 0 0;
    }
    .tb-table thead th:last-child {
        border-radius: 0 8px 0 0;
    }
    .tb-table tbody td {
        padding: 14px 18px;
        border-bottom: 1px solid #f0f0f0;
        font-size: 0.93rem;
        color: #374151;
    }
    .tb-table tbody tr:hover {
        background: #f5f3ff;
    }
    .tb-table tbody tr:last-child td:first-child {
        border-radius: 0 0 0 8px;
    }
    .tb-table tbody tr:last-child td:last-child {
        border-radius: 0 0 8px 0;
    }
    .tb-empty {
        text-align: center;
        padding: 40px 18px !important;
        color: #9ca3af;
        font-style: italic;
    }
</style>
