@extends('layouts.app')

@section('title', 'Activity Logs')

@section('content')
<div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
    <div>
        <h3 class="text-3xl font-black text-slate-800 tracking-tighter">Log Aktivitas</h3>
        <p class="text-slate-500 font-medium mt-1">Jejak audit menyeluruh tindakan sistem perpustakaan.</p>
    </div>
</div>

<div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden ring-1 ring-slate-200/50">
    <div class="p-10 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
        <div>
            <h4 class="text-sm font-black text-slate-800 tracking-[2px] uppercase">Aktivitas Terkini</h4>
            <p class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-widest">Sinkronisasi data real-time</p>
        </div>
        <div class="hidden sm:block">
            <span class="px-4 py-1.5 bg-violet-50 text-violet-600 text-[10px] font-black rounded-lg border border-violet-100 uppercase tracking-widest">
                {{ $logs->count() }} Entri Log
            </span>
        </div>
    </div>
    <div class="overflow-x-auto px-6 pb-6">
        <table class="w-full text-left border-separate border-spacing-y-2">
            <thead>
                <tr>
                    <th class="px-8 py-4 text-[11px] font-black text-slate-400 border-none uppercase tracking-[3px]">Pengguna</th>
                    <th class="px-8 py-4 text-[11px] font-black text-slate-400 border-none uppercase tracking-[3px]">Sifat Aktivitas</th>
                    <th class="px-8 py-4 text-[11px] font-black text-slate-400 border-none uppercase tracking-[3px]">Keterangan</th>
                    <th class="px-8 py-4 text-[11px] font-black text-slate-400 border-none uppercase tracking-[3px]">Metode & Waktu</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                    <td class="px-8 py-5 border-y border-l border-slate-100/50 rounded-l-2xl">
                        @if($log->user_id)
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 flex items-center justify-center bg-violet-100 text-violet-700 text-[10px] font-black border border-violet-200 rounded-xl shadow-sm">
                                    {{ substr($log->username, 0, 1) }}
                                </div>
                                <span class="text-sm font-black text-slate-700 tracking-tight">{{ $log->username }}</span>
                            </div>
                        @else
                            <span class="px-3 py-1 bg-slate-100 text-slate-400 text-[10px] font-black rounded-lg border border-slate-200 uppercase tracking-tighter">GUEST</span>
                        @endif
                    </td>
                    <td class="px-8 py-5 border-y border-slate-100/50">
                        @php
                            $colorIndex = 'violet';
                            if($log->activity == 'Login') $colorIndex = 'emerald';
                            if($log->activity == 'Logout') $colorIndex = 'amber';
                            if($log->activity == 'Register') $colorIndex = 'blue';
                            if(in_array($log->activity, ['Delete', 'Destroy'])) $colorIndex = 'rose';
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-md text-[10px] font-black bg-{{ $colorIndex }}-50 text-{{ $colorIndex }}-600 border border-{{ $colorIndex }}-100/50 uppercase tracking-widest shadow-sm shadow-{{ $colorIndex }}-100">
                            {{ $log->activity }}
                        </span>
                    </td>
                    <td class="px-8 py-5 border-y border-slate-100/50">
                        <span class="text-sm text-slate-600 font-medium tracking-tight">{{ $log->description }}</span>
                    </td>
                    <td class="px-8 py-5 border-y border-r border-slate-100/50 rounded-r-2xl">
                        <div class="text-[11px] font-black text-slate-700 tracking-tight">{{ $log->created_at->diffForHumans() }}</div>
                        <div class="text-[9px] text-slate-400 font-bold uppercase mt-0.5 tracking-[2px] opacity-60">{{ $log->ip_address }}</div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($logs->isEmpty())
        <div class="text-center py-24 bg-slate-50/10">
            <svg class="mx-auto h-12 w-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p class="mt-4 text-slate-300 font-black uppercase tracking-[5px] text-xs">Jejak Nihil</p>
        </div>
    @endif
</div>
@endsection
