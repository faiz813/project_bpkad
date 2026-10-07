@extends('layouts.app')

@section('title', 'Dashboard Admin — BPKAD')

@section('body')
<div class="min-h-screen flex flex-col justify-between font-sans relative overflow-hidden"
    style="background: linear-gradient(135deg, rgba(241, 245, 249, 0.90) 0%, rgba(226, 232, 240, 0.92) 100%), url('{{ asset('images/latar/gedung-bpkad.png') }}') center/cover no-repeat fixed;">
    
    {{-- Header / Navigation Bar --}}
    <header class="w-full border-b border-slate-200 bg-white/95 backdrop-blur-md sticky top-0 z-40 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('portal') }}">
                    <img src="{{ asset('images/logo-bpkad.png') }}" alt="Logo BPKAD" class="h-10 sm:h-12 w-auto object-contain">
                </a>
                <div>
                    <h1 class="font-bold text-slate-900 text-base leading-tight">Dashboard Admin</h1>
                    <p class="text-xs text-slate-500 font-medium">Buku Tamu Digital BPKAD</p>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                {{-- Sound Toggle Button --}}
                <button id="soundToggle" type="button" title="Aktifkan/Matikan Notifikasi Suara"
                    class="inline-flex items-center px-2.5 py-1.5 rounded-lg text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 border border-slate-300 transition">
                    <svg id="soundOnIcon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/></svg>
                    <svg id="soundOffIcon" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/></svg>
                </button>

                <a href="{{ route('portal') }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 transition">
                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Portal Utama
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 transition">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full flex-grow space-y-6">
        
        {{-- Success Flash Message --}}
        @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-2 text-sm font-semibold shadow-sm">
            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
        @endif

        {{-- Error Flash Message --}}
        @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm font-semibold shadow-sm">
            <div class="flex items-center gap-2 mb-1">
                <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Mohon perbaiki data input:</span>
            </div>
            <ul class="list-disc list-inside text-xs font-normal text-red-700 space-y-0.5 ml-2">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Title & Export Actions --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Data Kehadiran Tamu</h2>
                <p class="text-slate-500 text-sm mt-0.5">Daftar rekapan kunjungan tamu real-time BPKAD.</p>
            </div>
            
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.export.excel', request()->query()) }}"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-emerald-600 hover:bg-emerald-700 text-white shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Ekspor Excel
                </a>
                <button type="button" onclick="openExportPdfModal()"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold bg-red-600 hover:bg-red-700 text-white shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Ekspor PDF
                </button>
            </div>
        </div>

        {{-- New Guest Alert Banner (hidden by default) --}}
        <div id="newGuestBanner" class="hidden p-4 rounded-2xl bg-amber-500 text-white shadow-md flex items-center justify-between">
            <div class="flex items-center gap-2 font-bold text-sm">
                <svg class="w-5 h-5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                <span id="newGuestText">Ada data tamu baru masuk!</span>
            </div>
            <button onclick="window.location.reload()" class="px-3 py-1 rounded-lg bg-slate-900 hover:bg-slate-800 text-amber-400 font-bold text-xs transition">
                Refresh Halaman
            </button>
        </div>

        {{-- Statistics Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-900 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Hari Ini</p>
                        <p class="text-2xl font-extrabold text-slate-900">{{ $stats['today'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-900 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Minggu Ini</p>
                        <p class="text-2xl font-extrabold text-slate-900">{{ $stats['this_week'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-900 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Bulan Ini</p>
                        <p class="text-2xl font-extrabold text-slate-900">{{ $stats['this_month'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-900 flex items-center justify-center font-bold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Total</p>
                        <p class="text-2xl font-extrabold text-slate-900">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-emerald-200 shadow-sm col-span-2 lg:col-span-1">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                        <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Sedang Aktif</p>
                        <p class="text-2xl font-extrabold text-emerald-700">{{ $stats['active'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter & Search Section --}}
        <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm">
            <form method="GET" action="{{ route('admin.dashboard') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div class="md:col-span-2">
                    <label class="text-slate-600 text-xs font-semibold uppercase tracking-wider mb-1 block">Cari Data</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan nama, tujuan, bidang, atau alamat..."
                        class="w-full px-4 py-2 rounded-xl border border-slate-300 text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-blue-900 transition">
                </div>
                <div>
                    <label class="text-slate-600 text-xs font-semibold uppercase tracking-wider mb-1 block">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="w-full px-4 py-2 rounded-xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-blue-900 transition">
                </div>
                <div>
                    <label class="text-slate-600 text-xs font-semibold uppercase tracking-wider mb-1 block">Sampai Tanggal</label>
                    <div class="flex gap-2">
                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="w-full px-4 py-2 rounded-xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-blue-900 transition">
                        <button type="submit" class="px-4 py-2 rounded-xl bg-blue-900 hover:bg-slate-900 text-white font-semibold text-xs transition flex items-center justify-center">
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Guest Table --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-100/80 border-b border-slate-200 text-slate-700 text-xs font-bold uppercase tracking-wider">
                            <th class="py-3.5 px-4 text-center w-12">No</th>
                            <th class="py-3.5 px-4">Tanggal & Waktu</th>
                            <th class="py-3.5 px-4">Nama Lengkap</th>
                            <th class="py-3.5 px-4">Alamat</th>
                            <th class="py-3.5 px-4">No. HP/WA</th>
                            <th class="py-3.5 px-4">Bidang Dituju</th>
                            <th class="py-3.5 px-4">Tujuan / Keperluan</th>
                            <th class="py-3.5 px-4 text-center">TTD</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-800">
                        @forelse($tamus as $index => $tamu)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-3.5 px-4 text-center font-medium text-slate-500">
                                {{ $tamus->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4 font-semibold text-slate-900 whitespace-nowrap">
                                {{ $tamu->created_at->format('d/m/Y') }}
                                <span class="text-xs text-slate-500 font-normal block">{{ $tamu->created_at->format('H:i:s') }} WIB</span>
                            </td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">
                                {{ $tamu->nama_lengkap }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 max-w-xs truncate" title="{{ $tamu->alamat }}">
                                {{ $tamu->alamat }}
                            </td>
                            <td class="py-3.5 px-4 font-mono text-xs text-slate-700">
                                {{ $tamu->no_hp }}
                            </td>
                            <td class="py-3.5 px-4">
                                @if($tamu->bidang)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-800 border border-amber-200 max-w-[180px] truncate" title="{{ $tamu->bidang }}">
                                    {{ $tamu->bidang }}
                                </span>
                                @else
                                <span class="text-xs text-slate-400 italic">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 max-w-xs">
                                <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-900 border border-blue-200 whitespace-normal break-words" title="{{ $tamu->tujuan_display }}">
                                    {{ $tamu->tujuan_display }}
                                </span>
                                @if($tamu->tujuan === 'Lainnya' && $tamu->tujuan_lainnya)
                                <span class="block text-[10px] text-purple-700 font-semibold mt-0.5">Input Manual</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($tamu->tanda_tangan)
                                    <button onclick="previewSignature('{{ asset('storage/' . $tamu->tanda_tangan) }}', '{{ $tamu->nama_lengkap }}')"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-blue-900 bg-blue-50 hover:bg-blue-100 border border-blue-200 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Lihat TTD
                                    </button>
                                @else
                                    <span class="text-xs text-slate-400 italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @if($tamu->status_kunjungan === 'Selesai')
                                    <div>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Selesai
                                        </span>
                                        @if($tamu->checkout_at)
                                        <p class="text-[10px] text-slate-400 mt-1">{{ $tamu->checkout_at->format('H:i') }} WIB</p>
                                        @endif
                                    </div>
                                @else
                                    <div class="flex flex-col items-center gap-1.5">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                                            Aktif
                                        </span>
                                        <form method="POST" action="{{ route('admin.tamu.checkout', $tamu) }}" class="inline" onsubmit="return confirm('Selesaikan kunjungan tamu {{ $tamu->nama_lengkap }}?')">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[11px] font-semibold whitespace-nowrap text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 transition" title="Tandai Kunjungan Selesai">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                                Selesai Kunjungan
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    {{-- Edit Button --}}
                                    <button type="button"
                                        onclick="openEditModal(@js($tamu->id), @js($tamu->nama_lengkap), @js($tamu->alamat), @js($tamu->no_hp), @js($tamu->bidang), @js($tamu->tujuan_display))"
                                        class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-blue-900 bg-blue-50 hover:bg-blue-100 border border-blue-200 transition shadow-sm"
                                        title="Koreksi / Edit Data Tamu">
                                        <svg class="w-3.5 h-3.5 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>

                                    {{-- Hapus Button --}}
                                    <form method="POST" action="{{ route('admin.tamu.destroy', $tamu) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kunjungan tamu {{ addslashes($tamu->nama_lengkap) }}? Data akan dihapus dengan aman.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 transition shadow-sm"
                                            title="Hapus Data Tamu">
                                            <svg class="w-3.5 h-3.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="py-12 text-center text-slate-400 font-medium">
                                Belum ada data tamu yang tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination Links --}}
            @if($tamus->hasPages())
                <div class="px-4 py-3 border-t border-slate-200 bg-slate-50">
                    {{ $tamus->links() }}
                </div>
            @endif
        </div>
    </main>

    {{-- Footer --}}
    <footer class="w-full border-t border-slate-200 py-4 bg-white text-center text-xs text-slate-500 font-medium">
        <p>&copy; {{ date('Y') }} Badan Pengelolaan Keuangan dan Aset Daerah (BPKAD)</p>
    </footer>
</div>

{{-- Signature Preview Modal --}}
<div id="signatureModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 border border-slate-200 shadow-2xl relative animate-fade-in-up">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
            <h3 class="font-bold text-slate-900 text-base" id="modalGuestName">Tanda Tangan Digital</h3>
            <button onclick="closeSignatureModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex justify-center items-center">
            <img id="modalSignatureImg" src="" alt="Signature Preview" class="max-h-56 object-contain">
        </div>
        <div class="mt-4 text-right">
            <button onclick="closeSignatureModal()" class="px-4 py-2 rounded-xl bg-slate-900 text-white font-semibold text-xs">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- Edit Guest Modal --}}
<div id="editModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-lg w-full p-6 sm:p-7 border border-slate-200 shadow-2xl relative animate-fade-in-up my-8">
        <div class="flex items-center justify-between pb-3 border-b border-slate-200 mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-900 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <h3 class="font-bold text-slate-900 text-base">Edit Data Tamu</h3>
            </div>
            <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form id="editForm" method="POST" action="" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="edit_nama_lengkap" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_lengkap" id="edit_nama_lengkap" required
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-blue-900 transition">
            </div>

            <div>
                <label for="edit_no_hp" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                    No. HP / WhatsApp <span class="text-red-500">*</span>
                </label>
                <input type="text" name="no_hp" id="edit_no_hp" required
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-blue-900 transition">
            </div>

            <div>
                <label for="edit_alamat" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                    Alamat / Asal Instansi <span class="text-red-500">*</span>
                </label>
                <textarea name="alamat" id="edit_alamat" rows="2" required
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-blue-900 transition resize-none"></textarea>
            </div>

            <div>
                <label for="edit_bidang" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                    Bidang yang Dituju <span class="text-red-500">*</span>
                </label>
                <select name="bidang" id="edit_bidang" required
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-slate-900 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-blue-900 transition">
                    @foreach($bidangOptions as $opt)
                        <option value="{{ $opt }}">{{ $opt }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="edit_tujuan" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                    Tujuan / Keperluan Kunjungan <span class="text-red-500">*</span>
                </label>
                <textarea name="tujuan" id="edit_tujuan" rows="3" required
                    class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-blue-900 transition resize-none"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-200">
                <button type="button" onclick="closeEditModal()"
                    class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 rounded-xl bg-blue-900 hover:bg-slate-900 text-white font-bold text-xs shadow-sm transition flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Export PDF Modal (Per Hari, Per Minggu, Per Bulan, Per Tahun) --}}
<div id="exportPdfModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-xl w-full p-6 sm:p-7 border border-slate-200 shadow-2xl relative animate-fade-in-up my-8">
        {{-- Modal Header --}}
        <div class="flex items-center justify-between pb-3.5 border-b border-slate-200 mb-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-red-100 text-red-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Ekspor PDF Data Kehadiran Tamu</h3>
                    <p class="text-xs text-slate-500">Pilih periode laporan yang ingin diunduh</p>
                </div>
            </div>
            <button type="button" onclick="closeExportPdfModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Quick Export Cards (1-Click) --}}
        <div class="mb-5">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2.5">Pilihan Cepat (1-Klik Unduh)</p>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                {{-- Hari Ini --}}
                <a href="{{ route('admin.export.pdf', ['periode' => 'hari', 'tanggal' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d')]) }}"
                    target="_blank"
                    class="group p-3 rounded-xl border border-slate-200 hover:border-red-500 hover:bg-red-50/50 transition text-center flex flex-col items-center justify-center">
                    <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 group-hover:bg-red-600 group-hover:text-white flex items-center justify-center transition mb-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-red-700">Per Hari</span>
                    <span class="text-[10px] text-slate-500 mt-0.5">Hari Ini</span>
                </a>

                {{-- Minggu Ini --}}
                <a href="{{ route('admin.export.pdf', ['periode' => 'minggu', 'tanggal' => now()->setTimezone('Asia/Jakarta')->format('Y-m-d')]) }}"
                    target="_blank"
                    class="group p-3 rounded-xl border border-slate-200 hover:border-red-500 hover:bg-red-50/50 transition text-center flex flex-col items-center justify-center">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white flex items-center justify-center transition mb-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-red-700">Per Minggu</span>
                    <span class="text-[10px] text-slate-500 mt-0.5">Minggu Ini</span>
                </a>

                {{-- Bulan Ini --}}
                <a href="{{ route('admin.export.pdf', ['periode' => 'bulan', 'bulan' => now()->setTimezone('Asia/Jakarta')->month, 'tahun' => now()->setTimezone('Asia/Jakarta')->year]) }}"
                    target="_blank"
                    class="group p-3 rounded-xl border border-slate-200 hover:border-red-500 hover:bg-red-50/50 transition text-center flex flex-col items-center justify-center">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 group-hover:bg-amber-600 group-hover:text-white flex items-center justify-center transition mb-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-red-700">Per Bulan</span>
                    <span class="text-[10px] text-slate-500 mt-0.5">{{ now()->setTimezone('Asia/Jakarta')->translatedFormat('M Y') }}</span>
                </a>

                {{-- Tahun Ini --}}
                <a href="{{ route('admin.export.pdf', ['periode' => 'tahun', 'tahun' => now()->setTimezone('Asia/Jakarta')->year]) }}"
                    target="_blank"
                    class="group p-3 rounded-xl border border-slate-200 hover:border-red-500 hover:bg-red-50/50 transition text-center flex flex-col items-center justify-center">
                    <div class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 group-hover:bg-purple-600 group-hover:text-white flex items-center justify-center transition mb-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-slate-800 group-hover:text-red-700">Per Tahun</span>
                    <span class="text-[10px] text-slate-500 mt-0.5">{{ now()->setTimezone('Asia/Jakarta')->year }}</span>
                </a>
            </div>
        </div>

        {{-- Custom Period Selector --}}
        <div>
            <div class="flex items-center justify-between mb-2.5">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kustomisasi Periode Pilihan</p>
            </div>

            {{-- Tabs --}}
            <div class="flex flex-wrap gap-1 bg-slate-100 p-1 rounded-xl mb-3.5 text-xs font-semibold">
                <button type="button" onclick="switchPdfTab('hari')" id="tabBtn_hari"
                    class="pdf-tab-btn flex-1 py-1.5 px-2 rounded-lg text-center transition bg-white text-slate-900 shadow-xs">
                    Per Hari
                </button>
                <button type="button" onclick="switchPdfTab('minggu')" id="tabBtn_minggu"
                    class="pdf-tab-btn flex-1 py-1.5 px-2 rounded-lg text-center transition text-slate-600 hover:text-slate-900">
                    Per Minggu
                </button>
                <button type="button" onclick="switchPdfTab('bulan')" id="tabBtn_bulan"
                    class="pdf-tab-btn flex-1 py-1.5 px-2 rounded-lg text-center transition text-slate-600 hover:text-slate-900">
                    Per Bulan
                </button>
                <button type="button" onclick="switchPdfTab('tahun')" id="tabBtn_tahun"
                    class="pdf-tab-btn flex-1 py-1.5 px-2 rounded-lg text-center transition text-slate-600 hover:text-slate-900">
                    Per Tahun
                </button>
                <button type="button" onclick="switchPdfTab('filter')" id="tabBtn_filter"
                    class="pdf-tab-btn flex-1 py-1.5 px-2 rounded-lg text-center transition text-slate-600 hover:text-slate-900">
                    Sesuai Filter
                </button>
            </div>

            {{-- Tab 1: Per Hari --}}
            <div id="tabPanel_hari" class="pdf-tab-panel">
                <form method="GET" action="{{ route('admin.export.pdf') }}" target="_blank" class="space-y-3">
                    <input type="hidden" name="periode" value="hari">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Tanggal:</label>
                        <input type="date" name="tanggal" value="{{ now()->setTimezone('Asia/Jakarta')->format('Y-m-d') }}" required
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600 transition">
                    </div>
                    <button type="submit"
                        class="w-full py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-sm transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Unduh PDF Harian
                    </button>
                </form>
            </div>

            {{-- Tab 2: Per Minggu --}}
            <div id="tabPanel_minggu" class="pdf-tab-panel hidden">
                <form method="GET" action="{{ route('admin.export.pdf') }}" target="_blank" class="space-y-3">
                    <input type="hidden" name="periode" value="minggu">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Tanggal dalam Pekan:</label>
                        <input type="date" name="tanggal" value="{{ now()->setTimezone('Asia/Jakarta')->format('Y-m-d') }}" required
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600 transition">
                        <p class="text-[11px] text-slate-500 mt-1">Sistem akan otomatis mengekspor seluruh data dari Senin sampai Minggu pada pekan tanggal yang dipilih.</p>
                    </div>
                    <button type="submit"
                        class="w-full py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-sm transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Unduh PDF Mingguan
                    </button>
                </form>
            </div>

            {{-- Tab 3: Per Bulan --}}
            <div id="tabPanel_bulan" class="pdf-tab-panel hidden">
                <form method="GET" action="{{ route('admin.export.pdf') }}" target="_blank" class="space-y-3">
                    <input type="hidden" name="periode" value="bulan">
                    <div class="grid grid-cols-2 gap-2.5">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Bulan:</label>
                            <select name="bulan" required
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-slate-900 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600 transition">
                                @php
                                    $bulanList = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                    $currentMonth = now()->setTimezone('Asia/Jakarta')->month;
                                @endphp
                                @foreach($bulanList as $num => $namaBulan)
                                    <option value="{{ $num }}" {{ $num === $currentMonth ? 'selected' : '' }}>{{ $namaBulan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Tahun:</label>
                            <select name="tahun" required
                                class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-slate-900 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600 transition">
                                @php
                                    $currentYear = now()->setTimezone('Asia/Jakarta')->year;
                                @endphp
                                @for($y = $currentYear + 1; $y >= $currentYear - 3; $y--)
                                    <option value="{{ $y }}" {{ $y === $currentYear ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-sm transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Unduh PDF Bulanan
                    </button>
                </form>
            </div>

            {{-- Tab 4: Per Tahun --}}
            <div id="tabPanel_tahun" class="pdf-tab-panel hidden">
                <form method="GET" action="{{ route('admin.export.pdf') }}" target="_blank" class="space-y-3">
                    <input type="hidden" name="periode" value="tahun">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Pilih Tahun:</label>
                        <select name="tahun" required
                            class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-slate-900 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-red-600 transition">
                            @php
                                $currentYear = now()->setTimezone('Asia/Jakarta')->year;
                            @endphp
                            @for($y = $currentYear + 1; $y >= $currentYear - 4; $y--)
                                <option value="{{ $y }}" {{ $y === $currentYear ? 'selected' : '' }}>Tahun {{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit"
                        class="w-full py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold text-xs shadow-sm transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Unduh PDF Tahunan
                    </button>
                </form>
            </div>

            {{-- Tab 5: Sesuai Filter / Semua --}}
            <div id="tabPanel_filter" class="pdf-tab-panel hidden">
                <div class="space-y-3">
                    <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-600">
                        <p class="font-semibold text-slate-800 mb-1">Informasi Filter Aktif:</p>
                        <ul class="list-disc list-inside space-y-0.5 text-[11px]">
                            <li>Pencarian: <span class="font-medium text-slate-900">{{ request('search') ?: '(Semua)' }}</span></li>
                            <li>Dari Tanggal: <span class="font-medium text-slate-900">{{ request('date_from') ?: '-' }}</span></li>
                            <li>Sampai Tanggal: <span class="font-medium text-slate-900">{{ request('date_to') ?: '-' }}</span></li>
                        </ul>
                    </div>
                    <a href="{{ route('admin.export.pdf', request()->query()) }}" target="_blank"
                        class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-sm transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Unduh PDF Sesuai Filter Aktif
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openExportPdfModal() {
        document.getElementById('exportPdfModal').classList.remove('hidden');
    }

    function closeExportPdfModal() {
        document.getElementById('exportPdfModal').classList.add('hidden');
    }

    function switchPdfTab(tabName) {
        document.querySelectorAll('.pdf-tab-panel').forEach(panel => {
            panel.classList.add('hidden');
        });
        document.querySelectorAll('.pdf-tab-btn').forEach(btn => {
            btn.classList.remove('bg-white', 'text-slate-900', 'shadow-xs');
            btn.classList.add('text-slate-600');
        });

        const targetPanel = document.getElementById('tabPanel_' + tabName);
        if (targetPanel) {
            targetPanel.classList.remove('hidden');
        }

        const targetBtn = document.getElementById('tabBtn_' + tabName);
        if (targetBtn) {
            targetBtn.classList.add('bg-white', 'text-slate-900', 'shadow-xs');
            targetBtn.classList.remove('text-slate-600');
        }
    }
    function openEditModal(id, nama, alamat, noHp, bidang, tujuan) {
        const form = document.getElementById('editForm');
        form.action = `/admin/tamu/${id}`;
        document.getElementById('edit_nama_lengkap').value = nama || '';
        document.getElementById('edit_alamat').value = alamat || '';
        document.getElementById('edit_no_hp').value = noHp || '';
        document.getElementById('edit_tujuan').value = tujuan || '';

        const bidangSelect = document.getElementById('edit_bidang');
        if (bidangSelect) {
            bidangSelect.value = bidang || '';
            if (bidang && bidangSelect.value !== bidang) {
                const opt = new Option(bidang, bidang, true, true);
                bidangSelect.add(opt);
            }
        }

        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    function previewSignature(src, name) {
        document.getElementById('modalSignatureImg').src = src;
        document.getElementById('modalGuestName').textContent = 'Tanda Tangan: ' + name;
        document.getElementById('signatureModal').classList.remove('hidden');
    }

    function closeSignatureModal() {
        document.getElementById('signatureModal').classList.add('hidden');
    }

    // ==========================================
    // Audio Notification using Web Audio API
    // ==========================================
    let audioEnabled = false;
    let audioContext = null;
    let userInteracted = false;

    // Enable audio on first interaction (browser autoplay policy)
    function enableAudio() {
        if (!userInteracted) {
            userInteracted = true;
            audioContext = new (window.AudioContext || window.webkitAudioContext)();
            audioEnabled = true;
            updateSoundIcon();
        }
    }
    document.addEventListener('click', enableAudio, { once: true });

    // Sound toggle
    document.getElementById('soundToggle').addEventListener('click', function(e) {
        e.stopPropagation();
        if (!userInteracted) {
            userInteracted = true;
            audioContext = new (window.AudioContext || window.webkitAudioContext)();
        }
        audioEnabled = !audioEnabled;
        updateSoundIcon();
    });

    function updateSoundIcon() {
        document.getElementById('soundOnIcon').classList.toggle('hidden', !audioEnabled);
        document.getElementById('soundOffIcon').classList.toggle('hidden', audioEnabled);
    }

    function playChime() {
        if (!audioEnabled || !audioContext) return;

        // Resume context if suspended (browser policy)
        if (audioContext.state === 'suspended') {
            audioContext.resume();
        }

        const now = audioContext.currentTime;

        // Chime: 3-note ascending tone
        const notes = [523.25, 659.25, 783.99]; // C5, E5, G5
        notes.forEach((freq, i) => {
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();

            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(freq, now + i * 0.15);

            gainNode.gain.setValueAtTime(0, now + i * 0.15);
            gainNode.gain.linearRampToValueAtTime(0.3, now + i * 0.15 + 0.05);
            gainNode.gain.exponentialRampToValueAtTime(0.001, now + i * 0.15 + 0.4);

            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);

            oscillator.start(now + i * 0.15);
            oscillator.stop(now + i * 0.15 + 0.5);
        });
    }

    // ==========================================
    // Auto-polling for new guest submissions
    // ==========================================
    document.addEventListener('DOMContentLoaded', function() {
        let lastCheck = new Date().toISOString();

        function checkNewGuests() {
            fetch(`/admin/api/new-guests?last_check=${encodeURIComponent(lastCheck)}`)
                .then(res => res.json())
                .then(data => {
                    if (data.count > 0) {
                        const banner = document.getElementById('newGuestBanner');
                        const text = document.getElementById('newGuestText');
                        text.textContent = `Ada ${data.count} data tamu baru masuk! Sila refresh halaman.`;
                        banner.classList.remove('hidden');

                        // Play audio chime notification
                        playChime();
                    }
                })
                .catch(err => console.log('Polling error:', err));
        }

        setInterval(checkNewGuests, 10000);
    });
</script>
@endpush
