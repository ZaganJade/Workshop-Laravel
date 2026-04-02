{{-- CSS khusus DataTables --}}
<style>
    .tb-badge {
        background: #dcfce7;
        color: #15803d;
    }

    /* DataTables custom theme */
    #myTable_wrapper .dataTables_filter input {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 6px 12px;
        outline: none;
        transition: border-color 0.2s;
    }
    #myTable_wrapper .dataTables_filter input:focus {
        border-color: #7c3aed;
        box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }
    #myTable_wrapper .dataTables_length select {
        border: 1.5px solid #e0e0e0;
        border-radius: 8px;
        padding: 4px 8px;
        outline: none;
    }
    table.dataTable thead th {
        background: linear-gradient(135deg, #7c3aed, #6d28d9) !important;
        color: #fff !important;
        padding: 14px 18px !important;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: none !important;
    }
    table.dataTable thead th:first-child {
        border-radius: 8px 0 0 0;
    }
    table.dataTable thead th:last-child {
        border-radius: 0 8px 0 0;
    }
    table.dataTable tbody td {
        padding: 14px 18px !important;
        font-size: 0.93rem;
        color: #374151;
    }
    table.dataTable tbody tr:hover {
        background: #f5f3ff !important;
    }
    table.dataTable.no-footer {
        border-bottom: 1px solid #f0f0f0 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #7c3aed, #6d28d9) !important;
        color: #fff !important;
        border: none !important;
        border-radius: 6px;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #ede9fe !important;
        color: #6d28d9 !important;
        border: none !important;
        border-radius: 6px;
    }
    .dataTables_wrapper .dataTables_info {
        font-size: 0.85rem;
        color: #6b7280;
    }
</style>
