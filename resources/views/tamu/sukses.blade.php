@extends('layouts.app')

@section('title', 'Pas Masuk Digital — Bukti Kehadiran Tamu BPKAD')

@section('body')
<div class="min-h-screen bg-slate-50 text-slate-800 flex flex-col justify-between items-center px-4 relative overflow-hidden font-sans">
    {{-- Background Glow --}}
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 rounded-full bg-emerald-100/60 blur-3xl pointer-events-none -z-10"></div>

    <div class="my-auto py-8 w-full max-w-lg">
        
        {{-- Pas Masuk Digital Card --}}
        <div id="pasMasuk" class="bg-white border border-slate-200 rounded-3xl shadow-xl relative overflow-hidden">
            
            {{-- Top Accent Bar --}}
            <div class="h-2 bg-gradient-to-r from-blue-900 via-blue-700 to-amber-500"></div>
            
            {{-- Card Header --}}
            <div class="p-6 sm:p-8 pb-0 text-center">
                <div class="mb-4 flex justify-center">
                    <div class="w-16 h-16 rounded-full bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/30">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 mb-1">Pas Masuk Digital</h1>
                <p class="text-emerald-700 font-bold text-sm">Bukti Kehadiran — BPKAD</p>
                <p class="text-slate-500 text-xs mt-1">Kunjungan Anda telah resmi tercatat di sistem.</p>
            </div>

            {{-- Divider --}}
            <div class="mx-6 sm:mx-8 my-5 border-t border-dashed border-slate-200"></div>

            {{-- Guest Summary --}}
            <div class="px-6 sm:px-8 pb-6 space-y-3.5">
                
                {{-- Nama --}}
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Nama Lengkap</p>
                        <p class="text-slate-900 font-bold text-sm">{{ $tamu->nama_lengkap }}</p>
                    </div>
                </div>

                {{-- Alamat --}}
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Alamat / Instansi</p>
                        <p class="text-slate-900 font-bold text-sm">{{ $tamu->alamat }}</p>
                    </div>
                </div>

                {{-- No HP --}}
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-50 text-blue-900 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">No. HP / WhatsApp</p>
                        <p class="text-slate-900 font-bold text-sm font-mono">{{ $tamu->no_hp }}</p>
                    </div>
                </div>

                {{-- Bidang Dituju --}}
                @if($tamu->bidang)
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Bidang Dituju</p>
                        <p class="text-slate-900 font-bold text-sm">{{ $tamu->bidang }}</p>
                    </div>
                </div>
                @endif

                {{-- Tujuan --}}
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-purple-50 text-purple-700 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Tujuan / Keperluan</p>
                        <p class="text-slate-900 font-bold text-sm whitespace-pre-line">{{ $tamu->tujuan_display }}</p>
                        @if($tamu->tujuan === 'Lainnya' && $tamu->tujuan_lainnya)
                            <span class="inline-block mt-1 text-[10px] font-semibold text-purple-700 bg-purple-100 px-2 py-0.5 rounded-md">Input Manual</span>
                        @endif
                    </div>
                </div>

                {{-- Waktu Masuk --}}
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Waktu Masuk (Real-Time WIB)</p>
                        <p class="text-slate-900 font-bold text-sm">{{ $tamu->created_at->translatedFormat('l, d F Y — H:i:s') }} WIB</p>
                    </div>
                </div>

                {{-- Status --}}
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider">Status Kunjungan</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                            Aktif
                        </span>
                    </div>
                </div>

                {{-- Tanda Tangan --}}
                @if($tamu->tanda_tangan)
                <div class="pt-2">
                    <p class="text-slate-500 text-xs font-semibold uppercase tracking-wider mb-2">Tanda Tangan</p>
                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 flex justify-center">
                        <img src="{{ asset('storage/' . $tamu->tanda_tangan) }}" alt="Tanda Tangan" class="max-h-24 object-contain">
                    </div>
                </div>
                @endif
            </div>

            {{-- Bottom Accent --}}
            <div class="h-1 bg-gradient-to-r from-amber-500 via-blue-700 to-blue-900"></div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-5 flex flex-col sm:flex-row items-center justify-center gap-3">
            <button onclick="window.print()"
                class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-blue-900 hover:bg-blue-800 text-white text-xs sm:text-sm font-semibold transition shadow-sm flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Simpan / Cetak Bukti
            </button>

            <a href="{{ route('portal') }}"
                class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white text-xs sm:text-sm font-semibold transition shadow-sm flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Kembali ke Beranda
            </a>

            <a href="{{ route('tamu.create') }}"
                class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-white hover:bg-slate-50 text-slate-700 text-xs sm:text-sm font-semibold border border-slate-300 transition shadow-sm flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                Input Tamu Lainnya
            </a>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="w-full py-4 text-center text-xs text-slate-500 font-medium">
        <p>&copy; {{ date('Y') }} Badan Pengelolaan Keuangan dan Aset Daerah (BPKAD)</p>
    </footer>
</div>

{{-- Print Styles --}}
<style>
    @media print {
        body * { visibility: hidden; }
        #pasMasuk, #pasMasuk * { visibility: visible; }
        #pasMasuk { 
            position: absolute; left: 0; top: 0; 
            width: 100%; max-width: 100%;
            box-shadow: none; border: 1px solid #ddd;
            border-radius: 0;
        }
        footer, button, a { display: none !important; }
    }
</style>
@endsection
