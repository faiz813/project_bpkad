@extends('layouts.app')

@section('title', 'Portal Utama — Buku Tamu Digital BPKAD')

@section('body')
<div class="min-h-screen flex flex-col justify-between relative overflow-hidden font-sans"
    style="background: linear-gradient(180deg, rgba(255, 255, 255, 0.20) 0%, rgba(241, 245, 249, 0.40) 45%, rgba(226, 232, 240, 0.60) 100%), url('{{ asset('images/latar/gedung-bpkad.jpg') }}') center/cover no-repeat fixed;">

    {{-- Top Navigation Bar --}}
    <header class="w-full border-b border-white/40 bg-white/90 backdrop-blur-md sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo-bpkad.png') }}" alt="Logo BPKAD" class="h-10 sm:h-12 w-auto object-contain">
                <div>
                    <span class="font-bold text-slate-900 text-base leading-tight block">BPKAD</span>
                    <span class="text-xs text-slate-500 font-medium block">Buku Tamu Digital</span>
                </div>
            </div>

            <div class="flex items-center space-x-3 text-xs sm:text-sm font-medium">
                <span id="liveClock" class="hidden md:inline-flex items-center px-3.5 py-1 rounded-full bg-slate-100/90 text-slate-700 border border-slate-300 shadow-xs">
                    <svg class="w-4 h-4 mr-1.5 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span id="clockText">Memuat waktu...</span>
                </span>
                <a href="{{ route('login') }}" class="inline-flex items-center px-3.5 py-1.5 rounded-lg text-slate-700 bg-white hover:bg-slate-50 border border-slate-300 font-semibold transition shadow-xs">
                    <svg class="w-4 h-4 mr-1.5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Login Admin
                </a>
            </div>
        </div>
    </header>

    {{-- Main Portal Body --}}
    <main class="my-auto py-10 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto w-full">
        {{-- Hero Header Box (Kotak Sambutan Putih Solid) --}}
        <div class="text-center max-w-2xl mx-auto mb-8 flex flex-col items-center p-6 sm:p-8 rounded-3xl bg-white shadow-xl border border-slate-200"
            style="background-color: #ffffff !important;">
            <img src="{{ asset('images/logo-bpkad.png') }}" alt="Logo Resmi BPKAD" class="h-20 sm:h-24 w-auto object-contain mb-3 drop-shadow-sm">
            
            <span class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-bold bg-blue-900 text-amber-400 border border-blue-800 mb-3 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-amber-400 mr-2 animate-pulse"></span>
                Portal Layanan Digital BPKAD
            </span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                Selamat Datang di <span class="text-blue-900">Buku Tamu Digital</span>
            </h1>
            <p class="mt-2.5 text-slate-600 text-xs sm:text-sm leading-relaxed font-medium">
                Silakan pilih menu layanan di bawah ini untuk mengisi data kehadiran tamu atau masuk ke sistem administrasi data.
            </p>
        </div>

        {{-- 2 Cards Selection (Dua Kartu Putih Solid dengan Warna Tulisan Menarik) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
            
            {{-- Card 1: Input Data Tamu --}}
            <a href="{{ route('tamu.create') }}" class="group relative bg-white rounded-3xl p-8 border-2 border-transparent hover:border-blue-500 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between overflow-hidden"
                style="background-color: #ffffff !important;">
                <div class="absolute top-0 right-0 w-32 h-32 rounded-bl-full -mr-8 -mt-8 group-hover:scale-110 transition-transform duration-300 pointer-events-none"
                    style="background-color: #eff6ff;"></div>
                
                <div class="relative z-10">
                    {{-- Icon Kotak Biru --}}
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5 shadow-md shadow-blue-900/15 group-hover:scale-105 transition-transform duration-300"
                        style="background-color: #1e3a8a; color: #fbbf24;">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>

                    {{-- Badge --}}
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold mb-3"
                        style="background-color: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe;">
                        <span class="w-1.5 h-1.5 rounded-full mr-1.5" style="background-color: #2563eb;"></span>
                        Akses Tamu / Pengunjung
                    </div>

                    {{-- Nama Card / Judul Berwarna Biru Elegan --}}
                    <h2 class="text-2xl font-black transition-colors tracking-tight"
                        style="color: #1e3a8a;">
                        Input Data Tamu
                    </h2>

                    <p class="mt-2.5 text-slate-600 text-xs sm:text-sm leading-relaxed font-normal">
                        Formulir pendaftaran digital bagi tamu dan pengunjung dinas BPKAD dilengkapi verifikasi keamanan otomatis dan pas masuk digital.
                    </p>
                </div>

                <div class="mt-8 pt-5 flex items-center justify-between relative z-10"
                    style="border-top: 1px solid #f1f5f9;">
                    <span class="text-xs font-bold transition-colors" style="color: #1e3a8a;">Isi Formulir Kehadiran</span>
                    <span class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 shadow-md"
                        style="background-color: #1e3a8a; color: #fbbf24;">
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </span>
                </div>
            </a>

            {{-- Card 2: Login Admin --}}
            <a href="{{ route('login') }}" class="group relative bg-white rounded-3xl p-8 border-2 border-transparent hover:border-yellow-500 shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between overflow-hidden"
                style="background-color: #ffffff !important;">
                <div class="absolute top-0 right-0 w-32 h-32 rounded-bl-full -mr-8 -mt-8 group-hover:scale-110 transition-transform duration-300 pointer-events-none"
                    style="background-color: #fffbeb;"></div>

                <div class="relative z-10">
                    {{-- Icon Kotak Slate Gelap --}}
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5 shadow-md shadow-slate-900/15 group-hover:scale-105 transition-transform duration-300"
                        style="background-color: #0f172a; color: #fbbf24;">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>

                    {{-- Badge --}}
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold mb-3"
                        style="background-color: #fef3c7; color: #92400e; border: 1px solid #fde68a;">
                        <span class="w-1.5 h-1.5 rounded-full mr-1.5" style="background-color: #d97706;"></span>
                        Khusus Petugas / Admin
                    </div>

                    {{-- Nama Card / Judul Berwarna Slate Keemasan Elegan --}}
                    <h2 class="text-2xl font-black transition-colors tracking-tight"
                        style="color: #0f172a;">
                        Login Admin
                    </h2>

                    <p class="mt-2.5 text-slate-600 text-xs sm:text-sm leading-relaxed font-normal">
                        Halaman autentikasi administrator untuk rekapitulasi data tamu harian/mingguan/bulanan/tahunan dan cetak laporan PDF/Excel.
                    </p>
                </div>

                <div class="mt-8 pt-5 flex items-center justify-between relative z-10"
                    style="border-top: 1px solid #f1f5f9;">
                    <span class="text-xs font-bold transition-colors" style="color: #92400e;">Masuk Dashboard Admin</span>
                    <span class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 shadow-md"
                        style="background-color: #0f172a; color: #fbbf24;">
                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </span>
                </div>
            </a>

        </div>
    </main>

    {{-- Footer --}}
    <footer class="w-full border-t border-white/30 py-4 bg-white/90 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 text-center text-xs text-slate-600 font-medium">
            <p>&copy; {{ date('Y') }} Badan Pengelolaan Keuangan dan Aset Daerah (BPKAD) Kabupaten Garut. All rights reserved.</p>
        </div>
    </footer>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function updateClock() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            const el = document.getElementById('clockText');
            if (el) el.textContent = now.toLocaleDateString('id-ID', options);
        }
        updateClock();
        setInterval(updateClock, 1000);
    });
</script>
@endpush
