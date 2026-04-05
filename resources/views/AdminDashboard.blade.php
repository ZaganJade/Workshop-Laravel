@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

    {{-- Custom Dashboard Styles --}}
    <style>
        .dash-wrapper { padding: 0.5rem 1rem; }

        /* Hero Header */
        .dash-header {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            border-radius: 20px;
            padding: 28px 32px;
            margin-bottom: 28px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 10px 40px rgba(79, 70, 229, 0.3);
        }
        .dash-header h2 { font-size: 1.6rem; font-weight: 800; margin: 0 0 4px 0; }
        .dash-header p  { margin: 0; opacity: 0.8; font-size: 0.9rem; }
        .dash-header-actions { display: flex; gap: 10px; }
        .btn-dash-outline {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            border-radius: 50px;
            padding: 8px 20px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
        }
        .btn-dash-outline:hover { background: rgba(255,255,255,0.25); color: white; }

        /* Stat Cards */
        .stat-card {
            border-radius: 18px;
            padding: 24px;
            color: white;
            border: none;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            position: relative;
            overflow: hidden;
        }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 14px 30px rgba(0,0,0,0.15); }
        .stat-card .card-value { font-size: 2.2rem; font-weight: 800; margin: 16px 0 4px 0; line-height: 1; }
        .stat-card .card-label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; opacity: 0.85; margin: 0; }
        .stat-card .card-icon {
            width: 48px; height: 48px; border-radius: 14px;
            background: rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
        }
        .stat-card .card-badge {
            position: absolute; top: 20px; right: 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 50px; padding: 2px 10px;
            font-size: 0.75rem; font-weight: 600;
        }
        .stat-card .bg-shape {
            position: absolute; bottom: -20px; right: -20px;
            font-size: 7rem; opacity: 0.08; line-height: 1;
        }
        .card-buku    { background: linear-gradient(135deg, #4f46e5, #2563eb); }
        .card-kategori { background: linear-gradient(135deg, #059669, #0d9488); }
        .card-user    { background: linear-gradient(135deg, #f97316, #ef4444); }
        .card-barang  { background: linear-gradient(135deg, #7c3aed, #4f46e5); }

        /* Content Cards */
        .content-card {
            background: #fff;
            border-radius: 18px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            overflow: hidden;
            height: 100%;
        }
        .content-card-header {
            padding: 20px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #f5f5f5;
        }
        .content-card-header h5 { font-weight: 700; margin: 0; font-size: 1rem; }
        .content-card-header a { font-size: 0.8rem; color: #4f46e5; font-weight: 600; text-decoration: none; }
        .content-card-header a:hover { text-decoration: underline; }

        /* Activity Table */
        .activity-table th {
            font-size: 0.7rem; letter-spacing: 0.5px; text-transform: uppercase;
            color: #9ca3af; font-weight: 600; padding: 12px 20px; border: 0;
            background: #fafafa;
        }
        .activity-table td { padding: 14px 20px; border-bottom: 1px solid #f9f9f9; vertical-align: middle; }
        .activity-table tr:last-child td { border-bottom: none; }
        .activity-table tr:hover td { background: #fafbff; }
        .user-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white; display: flex; align-items: center; justify-content: center;
            font-size: 0.75rem; font-weight: 700; flex-shrink: 0;
        }
        .activity-name { font-weight: 600; color: #111827; font-size: 0.875rem; }
        .activity-email { font-size: 0.75rem; color: #9ca3af; }
        .activity-badge {
            background: #ede9fe; color: #6d28d9;
            padding: 3px 10px; border-radius: 50px; font-size: 0.75rem; font-weight: 600;
            display: inline-block;
        }
        .activity-time { font-size: 0.75rem; color: #9ca3af; white-space: nowrap; }

        /* AI Panel Card */
        .ai-panel {
            background: #fff;
            border-radius: 18px;
            border: 1px solid #f0f0f0;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            padding: 28px 24px;
            text-align: center;
        }
        .ai-panel .ai-icon-wrap {
            width: 72px; height: 72px; border-radius: 20px; margin: 0 auto 16px;
            background: linear-gradient(135deg, #ede9fe, #ddd6fe);
            display: flex; align-items: center; justify-content: center;
        }
        .ai-panel .ai-icon-wrap i { font-size: 2.2rem; color: #7c3aed; }
        .ai-panel h5 { font-weight: 700; margin-bottom: 8px; }
        .ai-panel p { font-size: 0.84rem; color: #6b7280; margin-bottom: 20px; line-height: 1.6; }
        .btn-ai-primary {
            display: block; width: 100%;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white; border: none; border-radius: 50px;
            padding: 10px; font-weight: 600; font-size: 0.875rem; cursor: pointer;
            transition: all 0.2s; margin-bottom: 10px;
        }
        .btn-ai-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(79,70,229,0.35); color: white; }
        .btn-ai-secondary {
            display: block; width: 100%;
            background: transparent; color: #6b7280; border: 1px solid #e5e7eb;
            border-radius: 50px; padding: 9px; font-size: 0.85rem; cursor: pointer;
            transition: all 0.2s; text-decoration: none;
        }
        .btn-ai-secondary:hover { background: #f9fafb; color: #374151; }

        /* Stats Banner */
        .stats-banner {
            background: linear-gradient(135deg, #1e1b4b, #312e81);
            border-radius: 16px; padding: 24px;
            color: white; position: relative; overflow: hidden;
            margin-top: 16px;
        }
        .stats-banner h6 { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; opacity: 0.6; margin-bottom: 12px; }
        .stats-banner .progress-bar-custom { background: rgba(255,255,255,0.1); border-radius: 50px; height: 5px; margin-bottom: 12px; }
        .stats-banner .progress-fill { background: rgba(255,255,255,0.7); border-radius: 50px; height: 5px; }
        .stats-banner p { font-size: 0.8rem; opacity: 0.65; margin: 0; }
        .stats-banner .banner-bg-icon { position: absolute; bottom: -15px; right: -10px; font-size: 6rem; opacity: 0.05; }
    </style>

    <div class="dash-wrapper">

        {{-- Header --}}
        <div class="dash-header">
            <div>
                <h2>Dashboard Overview</h2>
                <p>Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>! Terakhir diperbarui pukul {{ date('H:i') }}.</p>
            </div>
            <div class="dash-header-actions d-none d-md-flex">
                <span class="btn-dash-outline">📊 Laporan</span>
                <a href="{{ route('admin.buku.index') }}" class="btn-dash-outline">📚 Kelola Buku</a>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="row g-3 mb-4">
            {{-- Buku --}}
            <div class="col-xl-3 col-sm-6">
                <div class="stat-card card-buku">
                    <div class="card-icon"><i class="mdi mdi-book-open-page-variant"></i></div>
                    <div class="card-badge">📚 Koleksi</div>
                    <div class="card-value">{{ number_format($stats['total_buku']) }}</div>
                    <p class="card-label">Total Koleksi Buku</p>
                    <div class="bg-shape"><i class="mdi mdi-book-multiple"></i></div>
                </div>
            </div>

            {{-- Kategori --}}
            <div class="col-xl-3 col-sm-6">
                <div class="stat-card card-kategori">
                    <div class="card-icon"><i class="mdi mdi-tag-multiple"></i></div>
                    <div class="card-badge">🏷️ Jenis</div>
                    <div class="card-value">{{ number_format($stats['total_kategori']) }}</div>
                    <p class="card-label">Kategori Buku</p>
                    <div class="bg-shape"><i class="mdi mdi-folder-multiple"></i></div>
                </div>
            </div>

            {{-- User --}}
            <div class="col-xl-3 col-sm-6">
                <div class="stat-card card-user">
                    <div class="card-icon"><i class="mdi mdi-account-group"></i></div>
                    <div class="card-badge">👤 Aktif</div>
                    <div class="card-value">{{ number_format($stats['total_user']) }}</div>
                    <p class="card-label">Pengguna Terdaftar</p>
                    <div class="bg-shape"><i class="mdi mdi-account-multiple"></i></div>
                </div>
            </div>

            {{-- Barang --}}
            <div class="col-xl-3 col-sm-6">
                <div class="stat-card card-barang">
                    <div class="card-icon"><i class="mdi mdi-package-variant"></i></div>
                    <div class="card-badge">📦 Inventaris</div>
                    <div class="card-value">{{ number_format($stats['total_barang']) }}</div>
                    <p class="card-label">Total Inventaris Barang</p>
                    <div class="bg-shape"><i class="mdi mdi-store"></i></div>
                </div>
            </div>
        </div>

        {{-- Main Content --}}
        <div class="row g-3 align-items-start">

            {{-- Recent Activity --}}
            <div class="col-lg-8">
                <div class="content-card">
                    <div class="content-card-header">
                        <h5>🕐 Aktivitas Sistem Terbaru</h5>
                        @php
                            try {
                                echo '<a href="' . route('admin.logs.index') . '">Lihat Semua →</a>';
                            } catch (Exception $e) {
                            }
                        @endphp
                    </div>
                    <div class="table-responsive">
                        <table class="activity-table w-100">
                            <thead>
                                <tr>
                                    <th>Pengguna</th>
                                    <th>Aktivitas</th>
                                    <th class="text-end">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['recent_logs'] as $log)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="user-avatar">{{ strtoupper(substr(optional($log->user)->name ?? '?', 0, 1)) }}</div>
                                                <div>
                                                    <div class="activity-name">{{ optional($log->user)->name ?? 'Unknown' }}</div>
                                                    <div class="activity-email">{{ optional($log->user)->email ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="activity-badge">{{ $log->activity }}</span>
                                            @if($log->description)
                                                <div class="text-muted small mt-1">{{ Str::limit($log->description, 40) }}</div>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <span class="activity-time">{{ $log->created_at->diffForHumans() }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5 text-muted">
                                            <i class="mdi mdi-history" style="font-size:2rem; display:block; margin-bottom:8px; opacity:0.3;"></i>
                                            Belum ada aktivitas yang tercatat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Side Panel --}}
            <div class="col-lg-4">

                {{-- AI Chatbot Card --}}
                <div class="ai-panel">
                    <div class="ai-icon-wrap">
                        <i class="mdi mdi-robot-excited"></i>
                    </div>
                    <h5>Kimi AI Terhubung ✅</h5>
                    <p>Chatbot cerdas berbasis <strong>Kimi K2.5 Turbo</strong> siap membantu. Tanyakan stok buku, kategori, atau barang secara langsung!</p>
                    <button class="btn-ai-primary" onclick="toggleChatbot()">
                        🤖 Buka AI Chatbot
                    </button>
                    <a href="{{ route('admin.kategori.index') }}" class="btn-ai-secondary">Kelola Kategori</a>
                </div>

                {{-- Stats Banner --}}
                <div class="stats-banner">
                    <h6>Library Progress</h6>
                    <div class="progress-bar-custom">
                        @php
                            $pct = $stats['total_buku'] > 0 ? min(100, intval($stats['total_buku'] / 100 * 100)) : 0;
                        @endphp
                        <div class="progress-fill" style="width: {{ min($pct, 100) }}%"></div>
                    </div>
                    <p>Total <strong>{{ number_format($stats['total_buku']) }}</strong> buku dalam {{ number_format($stats['total_kategori']) }} kategori kini terindeks di sistem ini.</p>
                    <div class="banner-bg-icon"><i class="mdi mdi-library"></i></div>
                </div>
            </div>

        </div>
    </div>

@endsection
