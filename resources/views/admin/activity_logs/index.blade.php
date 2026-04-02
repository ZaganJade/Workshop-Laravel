@extends('layouts.app')

@section('title', 'History Log Aktivitas')

@push('css')
{{-- DataTables CSS --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<style>
    .log-page-header {
        background: #fff;
        padding: 24px 30px;
        border-radius: 20px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
    }
    .log-page-header h3 {
        font-weight: 800;
        margin: 0;
        color: #1f2937;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .log-header-icon {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
    }

    .log-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid #f0f0f0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
        padding: 24px;
    }

    {{-- DataTables Custom Styles --}}
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #e5e7eb !important;
        border-radius: 8px !important;
        padding: 6px 12px !important;
        background-color: #f9fafb !important;
        outline: none !important;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #4f46e5 !important;
        background-color: #fff !important;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1) !important;
    }

    table.dataTable.no-footer {
        border-bottom: 1px solid #f3f4f6 !important;
        margin-top: 20px !important;
        margin-bottom: 20px !important;
    }
    table.dataTable thead th {
        background: #f8fafc !important;
        padding: 15px 20px !important;
        font-size: 0.75rem !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        color: #64748b !important;
        border-bottom: 1px solid #e2e8f0 !important;
    }
    table.dataTable tbody td {
        padding: 16px 20px !important;
        border-bottom: 1px solid #f1f5f9 !important;
        font-size: 0.875rem !important;
        color: #334155 !important;
        vertical-align: middle !important;
    }
    table.dataTable tbody tr:hover {
        background-color: #f8fafc !important;
    }

    {{-- Pagination Styling --}}
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #4f46e5 !important;
        color: white !important;
        border: 1px solid #4f46e5 !important;
        border-radius: 8px !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #eef2ff !important;
        border: 1px solid #e0e7ff !important;
        color: #4f46e5 !important;
        border-radius: 8px !important;
    }

    {{-- Badges --}}
    .badge-log {
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
    }
    .badge-login { background: #ecfdf5; color: #059669; border: 1px solid #d1fae5; }
    .badge-logout { background: #fff7ed; color: #d97706; border: 1px solid #ffedd5; }
    .badge-delete { background: #fef2f2; color: #dc2626; border: 1px solid #fee2e2; }
    .badge-access { background: #eef2ff; color: #4f46e5; border: 1px solid #e0e7ff; }
    .badge-default { background: #f9fafb; color: #6b7280; border: 1px solid #f3f4f6; }

    .user-pill {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #e0e7ff;
        color: #4338ca;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.75rem;
    }
</style>
@endpush

@section('content')
<div class="log-page-header">
    <h3>
        <div class="log-header-icon">
            <i class="mdi mdi-history"></i>
        </div>
        Log Aktivitas Sistem
    </h3>
    <div style="font-size: 0.8rem; color: #6b7280; font-weight: 600; background: #f3f4f6; padding: 6px 16px; border-radius: 50px;">
        <i class="mdi mdi-sync me-1"></i> Terakhir sinkronisasi: {{ date('H:i:s') }}
    </div>
</div>

<div class="log-card">
    <table id="logTable" class="display w-100">
        <thead>
            <tr>
                <th>Pengguna</th>
                <th>Aktivitas</th>
                <th>Keterangan</th>
                <th>Waktu</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
            <tr>
                <td>
                    <div class="user-pill">
                        <div class="user-avatar">
                            {{ strtoupper(substr($log->username ?? 'G', 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight:700; color:#1f2937;">{{ $log->username ?? 'Guest' }}</div>
                            <div style="font-size:0.7rem; color:#9ca3af;">ID: {{ $log->user_id ?? '-' }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    @php
                        $class = match($log->activity) {
                            'Login' => 'badge-login',
                            'Logout' => 'badge-logout',
                            'Delete', 'Destroy' => 'badge-delete',
                            'Page Access', 'Access' => 'badge-access',
                            default => 'badge-default'
                        };
                    @endphp
                    <span class="badge-log {{ $class }}">
                        {{ $log->activity }}
                    </span>
                </td>
                <td>
                    <div style="font-weight:500; font-size:0.85rem;">{{ $log->description }}</div>
                </td>
                <td>
                    <div style="font-weight:700; color:#4b5563;">{{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}</div>
                    <div style="font-size:0.7rem; color:#9ca3af;">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, H:i') }}</div>
                </td>
                <td>
                    <div style="font-size:0.7rem; color:#6b7280; background:#f9fafb; padding:4px 8px; border-radius:6px; border:1px solid #f3f4f6; display:inline-block;">
                        <i class="mdi mdi-access-point me-1"></i> {{ $log->ip_address }}
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#logTable').DataTable({
            order: [[3, 'desc']], // Sort by Time column descending
            pageLength: 10,
            language: {
                search: "Cari log:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ log",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "Lanjut",
                    previous: "Kembali"
                },
                emptyTable: "Belum ada rekaman aktivitas."
            }
        });
    });
</script>
@endpush
