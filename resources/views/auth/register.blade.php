@extends('layouts.app')
@php $title = 'Daftar'; @endphp

@section('content')
<div class="max-w-md mx-auto px-4 py-16">
    <div class="text-center mb-8">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-6">
            <div class="w-12 h-12 rounded-2xl btn-glow flex items-center justify-center text-2xl font-bold text-slate-900 dark:text-white">T</div>
        </a>
        <h1 class="font-jakarta text-3xl font-bold text-slate-900 dark:text-white mb-2">Buat Akun Baru</h1>
        <p class="text-slate-500 dark:text-slate-400 text-sm">Bergabung dengan TechnoStore sekarang</p>
    </div>

    <div class="glass rounded-3xl p-8 border border-slate-200 dark:border-white/5 shadow-2xl relative overflow-hidden">
        {{-- Decorative element --}}
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-32 h-32 bg-purple-500/20 rounded-full blur-2xl pointer-events-none"></div>

        <form method="POST" action="{{ route('register') }}" class="relative z-10 space-y-5">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-2">Nama Lengkap</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                           class="w-full bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl pl-11 pr-4 py-3 text-slate-900 dark:text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500/50 transition-colors @error('name') border-red-500/50 @enderror"
                           placeholder="Nama Lengkap Anda">
                </div>
                @error('name')
                <p class="text-red-400 text-xs mt-1.5 ml-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                           class="w-full bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl pl-11 pr-4 py-3 text-slate-900 dark:text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500/50 transition-colors @error('email') border-red-500/50 @enderror"
                           placeholder="nama@email.com">
                </div>
                @error('email')
                <p class="text-red-400 text-xs mt-1.5 ml-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="w-full bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl pl-11 pr-4 py-3 text-slate-900 dark:text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500/50 transition-colors @error('password') border-red-500/50 @enderror"
                           placeholder="Minimal 8 karakter">
                </div>
                @error('password')
                <p class="text-red-400 text-xs mt-1.5 ml-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div>
                <label for="password_confirmation" class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-2">Konfirmasi Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl pl-11 pr-4 py-3 text-slate-900 dark:text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500/50 transition-colors @error('password_confirmation') border-red-500/50 @enderror"
                           placeholder="Ketik ulang password">
                </div>
                @error('password_confirmation')
                <p class="text-red-400 text-xs mt-1.5 ml-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="pt-4">
                <button type="submit" class="w-full btn-glow text-slate-900 dark:text-white font-bold py-3.5 rounded-xl flex items-center justify-center gap-2 text-base transition-all">
                    Daftar Akun
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </button>
            </div>
        </form>
    </div>

    <p class="text-center text-slate-500 dark:text-slate-400 text-sm mt-8">
        Sudah punya akun? 
        <a href="{{ route('login') }}" class="text-slate-900 dark:text-white font-semibold hover:text-blue-400 transition-colors">Masuk disini</a>
    </p>
</div>
@endsection
