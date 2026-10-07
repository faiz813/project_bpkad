@extends('layouts.app')

@section('title', 'Form Input Data Tamu — BPKAD')

@section('body')
<div class="min-h-screen bg-slate-50 text-slate-800 flex flex-col justify-between relative overflow-hidden font-sans">
    {{-- Background Decorative Accent --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-96 bg-gradient-to-b from-blue-100/50 via-amber-100/20 to-transparent blur-3xl pointer-events-none -z-10"></div>

    {{-- Header / Top Navigation --}}
    <header class="w-full border-b border-slate-200 bg-white/90 backdrop-blur-md sticky top-0 z-50 shadow-sm">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('portal') }}" class="inline-flex items-center text-xs sm:text-sm font-semibold text-slate-600 hover:text-blue-900 transition-colors">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Beranda
            </a>

            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo-bpkad.png') }}" alt="Logo BPKAD" class="h-9 sm:h-10 w-auto object-contain">
                <a href="{{ route('login') }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 border border-slate-300 transition">
                    Login Admin
                </a>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="py-8 px-4 sm:px-6 lg:px-8 max-w-2xl mx-auto w-full my-auto">
        
        {{-- Form Header --}}
        <div class="text-center mb-8 flex flex-col items-center">
            <img src="{{ asset('images/logo-bpkad.png') }}" alt="Logo Resmi BPKAD" class="h-20 sm:h-24 w-auto object-contain mb-3 drop-shadow-md">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Formulir Kehadiran Tamu</h1>
            <p class="text-slate-600 text-sm mt-1">Silakan lengkapi data kunjungan Anda di bawah ini secara lengkap.</p>
        </div>

        {{-- Auto-Fill Toast Notification (hidden by default) --}}
        <div id="autoFillToast" class="hidden mb-4 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 shadow-md animate-fade-in-up">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div class="flex-1">
                    <p class="font-bold text-emerald-900 text-sm">Data tamu ditemukan!</p>
                    <p class="text-emerald-700 text-xs mt-0.5">No. HP ini sudah pernah terdaftar. Apakah Anda ingin mengisi otomatis data Nama & Alamat?</p>
                    <div class="flex gap-2 mt-2.5">
                        <button type="button" id="autoFillYes" class="px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm">
                            Ya, Isi Otomatis
                        </button>
                        <button type="button" id="autoFillNo" class="px-3.5 py-1.5 rounded-lg bg-white hover:bg-slate-50 text-slate-700 text-xs font-semibold border border-slate-300 transition">
                            Tidak, Terima Kasih
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl p-6 sm:p-10 relative">
            
            {{-- Validation Errors --}}
            @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800">
                <div class="flex items-center gap-2 mb-1.5 font-bold text-sm">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Mohon lengkapi atau perbaiki data berikut:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-red-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form id="formTamu" action="{{ route('tamu.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Live Running Timestamp Card (Real-Time WIB - High Contrast) --}}
                <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border-2 border-slate-200/90 shadow-sm text-slate-800">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 flex items-center justify-center w-11 h-11 rounded-xl bg-blue-900 text-white shadow-md">
                                <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="relative flex h-2.5 w-2.5">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-600"></span>
                                    </span>
                                    <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700">Live • Real-Time WIB</span>
                                </div>
                                <p id="currentDateDisplay" class="text-xs sm:text-sm text-slate-700 font-semibold mt-0.5">
                                    {{ now()->setTimezone('Asia/Jakarta')->translatedFormat('l, d F Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-left sm:text-right border-t sm:border-t-0 border-slate-200 pt-2.5 sm:pt-0">
                            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-white border border-slate-300 shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-blue-900 animate-pulse"></span>
                                <div id="currentTimeDisplay" class="font-mono text-xl sm:text-2xl font-black tracking-wider text-slate-900">
                                    {{ now()->setTimezone('Asia/Jakarta')->format('H:i:s') }} WIB
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-500 font-mono mt-1">Zona Waktu: Asia/Jakarta</p>
                        </div>
                    </div>
                </div>

                <script>
                (function() {
                    function tick() {
                        const now = new Date();
                        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        const dateEl = document.getElementById('currentDateDisplay');
                        const timeEl = document.getElementById('currentTimeDisplay');
                        if (dateEl) dateEl.textContent = `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
                        if (timeEl) {
                            const h = String(now.getHours()).padStart(2, '0');
                            const m = String(now.getMinutes()).padStart(2, '0');
                            const s = String(now.getSeconds()).padStart(2, '0');
                            timeEl.textContent = `${h}:${m}:${s} WIB`;
                        }
                    }
                    tick();
                    setInterval(tick, 1000);
                })();
                </script>

                {{-- Nama Lengkap --}}
                <div>
                    <label for="nama_lengkap" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-blue-900 text-sm transition"
                        placeholder="Contoh: Budi Santoso" required autocomplete="name">
                </div>

                {{-- Alamat --}}
                <div>
                    <label for="alamat" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Alamat / Instansi asal <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alamat" id="alamat" rows="2"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-blue-900 text-sm transition resize-none"
                        placeholder="Masukkan alamat atau nama instansi Anda" required>{{ old('alamat') }}</textarea>
                </div>

                {{-- No HP --}}
                <div>
                    <label for="no_hp" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        No. HP / WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" name="no_hp" id="no_hp" value="{{ old('no_hp') }}"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-blue-900 text-sm transition"
                        placeholder="Contoh: 081234567890" required>
                    <p id="autoFillHint" class="hidden mt-1.5 text-xs text-emerald-600 font-medium">
                        <svg class="w-3.5 h-3.5 inline mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Mencari data tamu sebelumnya...
                    </p>
                </div>

                {{-- Bidang / Sub-Bagian yang Dituju --}}
                <div>
                    <label for="bidang" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Bidang / Sub-Bagian yang Dituju <span class="text-red-500">*</span>
                    </label>
                    <select name="bidang" id="bidang"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-slate-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-blue-900 text-sm transition" required>
                        <option value="">— Pilih Bidang yang Dituju —</option>
                        @foreach($bidangOptions as $option)
                            <option value="{{ $option }}" {{ old('bidang') === $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Tujuan / Keperluan (Langsung Input Textarea) --}}
                <div>
                    <label for="tujuan" class="block text-sm font-semibold text-slate-800 mb-1.5 flex items-center justify-between">
                        <span>Tujuan / Keperluan Kunjungan <span class="text-red-500">*</span></span>
                        <span class="text-[11px] font-medium text-slate-500">Ketik langsung secara spesifik</span>
                    </label>
                    <textarea name="tujuan" id="tujuan" rows="3"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-blue-900 text-sm transition resize-none"
                        placeholder="Masukkan keperluan atau tujuan kunjungan Anda secara spesifik..." required>{{ old('tujuan') }}</textarea>
                    <p class="text-[11px] text-slate-500 mt-1">
                        Contoh: Konsultasi penyusunan APBD, pencairan SP2D GU, koordinasi aset daerah, atau penyerahan berkas surat dinas.
                    </p>
                </div>

                {{-- Verifikasi Keamanan / Captcha Alfanumerik --}}
                <div class="p-4 rounded-2xl border border-slate-200 bg-slate-50/70 space-y-3">
                    <div class="flex items-center justify-between">
                        <label for="captchaInput" class="text-sm font-semibold text-slate-800 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <span>Verifikasi Keamanan <span class="text-red-500">*</span></span>
                        </label>
                        <button type="button" id="refreshCaptchaBtn" title="Ganti kode captcha"
                            class="inline-flex items-center gap-1 text-xs font-semibold text-blue-800 hover:text-blue-900 transition">
                            <svg id="refreshCaptchaIcon" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            <span>Ganti Kode</span>
                        </button>
                    </div>

                    <p class="text-xs text-slate-500">
                        Ketik kode verifikasi yang tertera di bawah ini persis sama (huruf besar/kecil tidak dibedakan):
                    </p>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        {{-- Captcha Code Display --}}
                        <div class="flex items-center justify-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-900 to-slate-900 shadow-sm select-none" style="min-width:180px;">
                            <span id="captchaCode" class="tracking-[0.35em] font-mono font-black text-xl"
                                style="
                                    background: linear-gradient(90deg, #fbbf24 0%, #f472b6 35%, #60a5fa 70%, #34d399 100%);
                                    -webkit-background-clip: text;
                                    -webkit-text-fill-color: transparent;
                                    background-clip: text;
                                    filter: drop-shadow(0 0 4px rgba(251,191,36,0.3));
                                    letter-spacing: 0.38em;
                                ">{{ $captcha['code'] }}</span>
                        </div>

                        {{-- Input Answer --}}
                        <div class="relative flex-1">
                            <input type="text" name="captcha" id="captchaInput"
                                data-expected="{{ $captcha['code'] }}"
                                value="{{ old('captcha') }}"
                                placeholder="Ketik kode di sini..."
                                autocomplete="off"
                                autocorrect="off"
                                autocapitalize="characters"
                                spellcheck="false"
                                maxlength="6"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-slate-900 font-mono font-semibold tracking-widest text-sm uppercase focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-blue-900 transition"
                                required>

                            {{-- Checkmark icon inside input --}}
                            <div id="captchaSuccessIcon" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Live feedback message --}}
                    <div id="captchaFeedback" class="text-xs font-medium text-slate-500 flex items-center gap-1.5 pt-0.5">
                        <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span id="captchaFeedbackText">Ketik kode verifikasi dengan tepat agar tombol kehadiran dapat diklik.</span>
                    </div>
                </div>

                {{-- Submit Button (Akan aktif setelah verifikasi/captcha selesai) --}}
                <button type="submit" id="submitBtn" disabled
                    class="w-full py-3.5 px-6 rounded-xl bg-slate-300 text-slate-500 font-bold text-sm tracking-wide shadow-none cursor-not-allowed transition-all duration-200 flex items-center justify-center gap-2">
                    <svg id="submitBtnIconLock" class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <svg id="submitBtnIconCheck" class="w-5 h-5 text-amber-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span id="submitBtnText">Selesaikan Verifikasi Terlebih Dahulu</span>
                </button>
            </form>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="w-full border-t border-slate-200 py-4 bg-white text-center text-xs text-slate-500 font-medium">
        <p>&copy; {{ date('Y') }} BPKAD — Sistem Buku Tamu Digital | <a href="{{ route('login') }}" class="text-blue-800 hover:underline font-semibold">Login Admin</a></p>
    </footer>
</div>
@endsection

@push('scripts')
<script>
(function () {
    // Live Running Digital Clock (HH:mm:ss WIB)
    function updateLiveClock() {
        const now = new Date();
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        const dayName = days[now.getDay()];
        const dateNum = now.getDate();
        const monthName = months[now.getMonth()];
        const yearNum = now.getFullYear();

        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        const dateEl = document.getElementById('currentDateDisplay');
        const timeEl = document.getElementById('currentTimeDisplay');

        if (dateEl) {
            dateEl.textContent = `${dayName}, ${dateNum} ${monthName} ${yearNum}`;
        }
        if (timeEl) {
            timeEl.textContent = `${hours}:${minutes}:${seconds} WIB`;
        }
    }
    updateLiveClock();
    setInterval(updateLiveClock, 1000);

    // ==========================================
    // Auto-Fill by Phone Number (Returning Guest)
    // ==========================================
    const noHpInput = document.getElementById('no_hp');
    const autoFillToast = document.getElementById('autoFillToast');
    const autoFillHint = document.getElementById('autoFillHint');
    let lookupData = null;
    let lookupTimeout = null;

    if (noHpInput) {
        noHpInput.addEventListener('input', function () {
            clearTimeout(lookupTimeout);
            const phone = this.value.replace(/\D/g, '');

            if (phone.length >= 8) {
                if (autoFillHint) autoFillHint.classList.remove('hidden');
                lookupTimeout = setTimeout(() => {
                    fetch(`/api/tamu/lookup-phone?no_hp=${encodeURIComponent(this.value)}`)
                        .then(res => res.json())
                        .then(data => {
                            if (autoFillHint) autoFillHint.classList.add('hidden');
                            if (data.found) {
                                lookupData = data;
                                if (autoFillToast) {
                                    autoFillToast.classList.remove('hidden');
                                    autoFillToast.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                }
                            } else {
                                if (autoFillToast) autoFillToast.classList.add('hidden');
                                lookupData = null;
                            }
                        })
                        .catch(() => {
                            if (autoFillHint) autoFillHint.classList.add('hidden');
                        });
                }, 600);
            } else {
                if (autoFillHint) autoFillHint.classList.add('hidden');
                if (autoFillToast) autoFillToast.classList.add('hidden');
                lookupData = null;
            }
        });
    }

    const autoFillYes = document.getElementById('autoFillYes');
    if (autoFillYes) {
        autoFillYes.addEventListener('click', function () {
            if (lookupData) {
                const namaEl = document.getElementById('nama_lengkap');
                const alamatEl = document.getElementById('alamat');
                if (namaEl) namaEl.value = lookupData.nama_lengkap;
                if (alamatEl) alamatEl.value = lookupData.alamat;
                [namaEl, alamatEl].forEach(el => {
                    if (el) {
                        el.classList.add('ring-2', 'ring-emerald-400', 'border-emerald-400');
                        setTimeout(() => el.classList.remove('ring-2', 'ring-emerald-400', 'border-emerald-400'), 2000);
                    }
                });
            }
            if (autoFillToast) autoFillToast.classList.add('hidden');
        });
    }

    const autoFillNo = document.getElementById('autoFillNo');
    if (autoFillNo) {
        autoFillNo.addEventListener('click', function () {
            if (autoFillToast) autoFillToast.classList.add('hidden');
            lookupData = null;
        });
    }

    // ==========================================
    // Captcha & Form Submit Verification
    // ==========================================
    const captchaInput = document.getElementById('captchaInput');
    const captchaCode = document.getElementById('captchaCode');
    const refreshCaptchaBtn = document.getElementById('refreshCaptchaBtn');
    const refreshCaptchaIcon = document.getElementById('refreshCaptchaIcon');
    const captchaSuccessIcon = document.getElementById('captchaSuccessIcon');
    const captchaFeedback = document.getElementById('captchaFeedback');
    const captchaFeedbackText = document.getElementById('captchaFeedbackText');
    const submitBtn = document.getElementById('submitBtn');
    const submitBtnText = document.getElementById('submitBtnText');
    const submitBtnIconLock = document.getElementById('submitBtnIconLock');
    const submitBtnIconCheck = document.getElementById('submitBtnIconCheck');

    let isCaptchaValid = false;

    function checkCaptcha() {
        if (!captchaInput) return;
        const expected = String(captchaInput.getAttribute('data-expected') || '').trim();
        const entered = String(captchaInput.value || '').trim();

        // Case-insensitive comparison for alphanumeric captcha
        if (entered !== '' && expected !== '' && entered.toUpperCase() === expected.toUpperCase()) {
            isCaptchaValid = true;

            // Valid State Styling
            captchaInput.style.borderColor = '#10b981';
            captchaInput.style.boxShadow = '0 0 0 3px rgba(16, 185, 129, 0.25)';
            captchaInput.style.backgroundColor = '#f0fdf4';
            if (captchaSuccessIcon) captchaSuccessIcon.classList.remove('hidden');

            if (captchaFeedbackText) captchaFeedbackText.textContent = '✓ Verifikasi berhasil! Tombol kehadiran sekarang dapat diklik.';
            if (captchaFeedback) captchaFeedback.style.color = '#059669';

            // Unlock submit button
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.removeAttribute('disabled');
                submitBtn.style.backgroundColor = '#1e3a5f';
                submitBtn.style.color = '#ffffff';
                submitBtn.style.cursor = 'pointer';
                submitBtn.style.boxShadow = '0 4px 10px rgba(30, 58, 95, 0.3)';
            }
            if (submitBtnText) submitBtnText.textContent = 'Simpan Kehadiran Tamu';
            if (submitBtnIconLock) submitBtnIconLock.classList.add('hidden');
            if (submitBtnIconCheck) submitBtnIconCheck.classList.remove('hidden');
        } else {
            isCaptchaValid = false;

            // Reset Input Style
            if (captchaSuccessIcon) captchaSuccessIcon.classList.add('hidden');
            captchaInput.style.backgroundColor = '';
            captchaInput.style.boxShadow = '';

            if (entered !== '') {
                captchaInput.style.borderColor = '#ef4444';
                if (captchaFeedbackText) captchaFeedbackText.textContent = 'Kode belum sesuai, periksa kembali huruf dan angka yang Anda ketik.';
                if (captchaFeedback) captchaFeedback.style.color = '#dc2626';
            } else {
                captchaInput.style.borderColor = '#cbd5e1';
                if (captchaFeedbackText) captchaFeedbackText.textContent = 'Ketik kode verifikasi dengan tepat agar tombol kehadiran dapat diklik.';
                if (captchaFeedback) captchaFeedback.style.color = '#64748b';
            }

            // Lock submit button
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.setAttribute('disabled', 'disabled');
                submitBtn.style.backgroundColor = '#cbd5e1';
                submitBtn.style.color = '#94a3b8';
                submitBtn.style.cursor = 'not-allowed';
                submitBtn.style.boxShadow = 'none';
            }
            if (submitBtnText) submitBtnText.textContent = 'Selesaikan Verifikasi Terlebih Dahulu';
            if (submitBtnIconLock) submitBtnIconLock.classList.remove('hidden');
            if (submitBtnIconCheck) submitBtnIconCheck.classList.add('hidden');
        }
    }

    if (captchaInput) {
        captchaInput.addEventListener('input', checkCaptcha);
        captchaInput.addEventListener('keyup', checkCaptcha);
        captchaInput.addEventListener('change', checkCaptcha);

        // Check on initial page load if browser auto-filled or old value present
        if (captchaInput.value.trim() !== '') {
            checkCaptcha();
        }
    }

    if (refreshCaptchaBtn) {
        refreshCaptchaBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (refreshCaptchaIcon) refreshCaptchaIcon.classList.add('animate-spin');

            fetch('{{ route('tamu.captcha-refresh') }}', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (captchaCode && data.code) {
                    captchaCode.textContent = data.code;
                }
                if (captchaInput && data.code) {
                    captchaInput.setAttribute('data-expected', data.code);
                    captchaInput.value = '';
                }
                checkCaptcha();
                if (captchaInput) captchaInput.focus();
            })
            .catch(err => {
                console.error('Captcha refresh error:', err);
                alert('Gagal memperbarui kode captcha. Silakan coba lagi.');
            })
            .finally(() => {
                if (refreshCaptchaIcon) refreshCaptchaIcon.classList.remove('animate-spin');
            });
        });
    }

    // Submit Handler
    const formTamu = document.getElementById('formTamu');
    if (formTamu) {
        formTamu.addEventListener('submit', function (e) {
            if (!isCaptchaValid) {
                e.preventDefault();
                if (captchaInput) {
                    captchaInput.focus();
                    captchaInput.style.borderColor = '#ef4444';
                }
                return;
            }

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="w-5 h-5 animate-spin text-amber-400 inline" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                    <span class="ml-2">Menyimpan Data Kehadiran...</span>
                `;
            }
        });
    }
})();
</script>
@endpush

