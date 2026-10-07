@extends('layouts.app')

@section('title', 'Login Admin — BPKAD')

@section('body')
<div class="min-h-screen bg-slate-50 text-slate-800 flex flex-col justify-between relative overflow-hidden font-sans">
    {{-- Background Decorative Accent --}}
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-96 bg-gradient-to-b from-amber-100/40 via-blue-100/20 to-transparent blur-3xl pointer-events-none -z-10"></div>

    {{-- Top Header / Navigation --}}
    <header class="w-full border-b border-slate-200 bg-white/90 backdrop-blur-md sticky top-0 z-50 shadow-sm">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('portal') }}" class="inline-flex items-center text-xs sm:text-sm font-semibold text-slate-600 hover:text-blue-900 transition-colors">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Beranda
            </a>

            <img src="{{ asset('images/logo-bpkad.png') }}" alt="Logo BPKAD" class="h-9 sm:h-10 w-auto object-contain">
        </div>
    </header>

    {{-- Main Login Card --}}
    <main class="py-12 px-4 sm:px-6 lg:px-8 max-w-md mx-auto w-full my-auto">
        <div class="text-center mb-8 flex flex-col items-center">
            <img src="{{ asset('images/logo-bpkad.png') }}" alt="Logo Resmi BPKAD" class="h-20 sm:h-24 w-auto object-contain mb-3 drop-shadow-md">
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Login Portal Admin</h1>
            <p class="text-slate-600 text-sm mt-1">Masukkan kredensial admin Anda untuk mengakses dashboard.</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-xl p-6 sm:p-8">
            
            {{-- Validation Errors / Status --}}
            @if(session('status'))
                <div class="mb-4 text-xs font-semibold text-emerald-700 bg-emerald-50 p-3 rounded-xl border border-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email Address --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Alamat Email Admin
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-blue-900 text-sm transition"
                        placeholder="admin@bpkad.go.id">
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Kata Sandi / Password
                    </label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-900 focus:border-blue-900 text-sm transition"
                        placeholder="••••••••">
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between text-xs">
                    <label for="remember_me" class="inline-flex items-center text-slate-600 font-medium cursor-pointer">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-blue-900 shadow-sm focus:ring-blue-900">
                        <span class="ml-2">Ingat Saya</span>
                    </label>
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                    class="w-full py-3 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm tracking-wide shadow-md transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <span>Masuk ke Dashboard</span>
                </button>
            </form>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="w-full border-t border-slate-200 py-4 bg-white text-center text-xs text-slate-500 font-medium">
        <p>&copy; {{ date('Y') }} Badan Pengelolaan Keuangan dan Aset Daerah (BPKAD)</p>
    </footer>
</div>
@endsection
