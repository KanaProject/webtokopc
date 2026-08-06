<!DOCTYPE html>
@php
    $storeSettings = \App\Models\SiteSetting::allAsArray();
    $storeName = $storeSettings['store_name'] ?? 'TechnoStore';
    $storeLogo = $storeSettings['store_logo'] ?? null;
@endphp
<html lang="id" x-data="{ darkMode: false }" x-init="darkMode = document.documentElement.classList.contains('dark'); $watch('darkMode', val => { if(val) { document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; } })">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' — Admin ' . $storeName : 'Admin Panel — ' . $storeName }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    <style>
        :root {
            --bg-primary: #F8FAFC;
            --bg-secondary: #F1F5F9;
            --bg-card: #FFFFFF;
            --accent-blue: #3B82F6;
            --accent-cyan: #06B6D4;
            --text-primary: #0F172A;
            --text-secondary: #475569;
        }
        .dark {
            --bg-primary: #060B18;
            --bg-secondary: #0D1526;
            --bg-card: #111827;
            --text-primary: #F1F5F9;
            --text-secondary: #94A3B8;
        }
        body { font-family: 'Inter', sans-serif; background: var(--bg-primary); color: var(--text-primary); transition: background-color 0.3s, color 0.3s; }
        .glass { background: rgba(255,255,255,0.7); backdrop-filter: blur(12px); border: 1px solid rgba(0,0,0,0.05); }
        .dark .glass { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); }
        .glass-blue { background: rgba(59,130,246,0.15); backdrop-filter: blur(12px); border: 1px solid rgba(59,130,246,0.3); }
        .dark .glass-blue { background: rgba(59,130,246,0.08); border: 1px solid rgba(59,130,246,0.2); }
        .gradient-text { background: linear-gradient(135deg, #3B82F6, #06B6D4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .btn-glow { background: linear-gradient(135deg, #3B82F6, #06B6D4); box-shadow: 0 0 20px rgba(59,130,246,0.4); }
        .sidebar-link { display: flex; align-items: center; gap: 10px; padding: 10px 16px; border-radius: 12px; font-size: 14px; font-weight: 500; color: #94A3B8; transition: all 0.2s; }
        .sidebar-link:hover, .sidebar-link.active { background: rgba(59,130,246,0.12); color: #fff; }
        .sidebar-link.active { border-left: 3px solid #3B82F6; padding-left: 13px; }
        .stat-card { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 20px; }
        .table-row:hover { background: rgba(255,255,255,0.03); }
        input, select, textarea { background: rgba(255,255,255,0.5) !important; border: 1px solid rgba(0,0,0,0.1) !important; border-radius: 12px; color: var(--text-primary) !important; }
        .dark input, .dark select, .dark textarea { background: rgba(255,255,255,0.05) !important; border: 1px solid rgba(255,255,255,0.1) !important; color: white !important; }
        input:focus, select:focus, textarea:focus { outline: none !important; border-color: rgba(59,130,246,0.5) !important; }
        select option { background: var(--bg-card); }
        ::-webkit-scrollbar { width: 4px; } ::-webkit-scrollbar-thumb { background: #3B82F6; border-radius: 4px; }
    </style>
</head>
<body class="antialiased" x-data="{ sideOpen: true }">
<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside :class="sideOpen ? 'w-64' : 'w-16'" class="flex-shrink-0 h-screen sticky top-0 flex flex-col transition-all duration-300 border-r border-slate-200 dark:border-white/5 bg-slate-50 dark:bg-[#0D1526]">
        <div class="p-4 border-b border-slate-200 dark:border-white/5">
            <a href="{{ route('home') }}" class="flex items-center gap-2 overflow-hidden">
                @if($storeLogo)
                    <img src="{{ Storage::url($storeLogo) }}" alt="{{ $storeName }}" class="h-9 w-auto object-contain flex-shrink-0">
                @else
                    <div class="w-9 h-9 rounded-xl btn-glow flex items-center justify-center text-white font-bold flex-shrink-0">{{ strtoupper(substr($storeName, 0, 1)) }}</div>
                @endif
                <span x-show="sideOpen" class="font-jakarta font-extrabold text-slate-900 dark:text-white whitespace-nowrap">{{ $storeName }}</span>
            </a>
        </div>

        <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
            <p x-show="sideOpen" class="text-slate-600 text-xs font-semibold uppercase tracking-widest px-3 py-2">Menu</p>

            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                <span x-show="sideOpen">Dashboard</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="sidebar-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span x-show="sideOpen">Produk</span>
            </a>
            <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z"/></svg>
                <span x-show="sideOpen">Kategori</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="sidebar-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span x-show="sideOpen">Pesanan</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="sidebar-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span x-show="sideOpen">Halaman Utama</span>
            </a>
            <hr class="border-white/5 my-2">
            <a href="{{ route('home') }}" class="sidebar-link">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span x-show="sideOpen">Lihat Toko</span>
            </a>
        </nav>

        <div class="p-3 border-t border-white/5">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-link w-full text-red-400 hover:text-red-300 hover:bg-red-500/10">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span x-show="sideOpen">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col min-w-0">
        {{-- Topbar --}}
        <header class="sticky top-0 z-40 border-b border-slate-200 dark:border-white/5 px-6 py-3 flex items-center justify-between bg-white/90 dark:bg-[#060B18]/90 backdrop-blur-md">
            <div class="flex items-center gap-4">
                <button @click="sideOpen=!sideOpen" class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-slate-900 dark:text-white font-semibold">{{ $title ?? 'Admin Panel' }}</h1>
            </div>
            <div class="flex items-center gap-4">
                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode" class="p-2 text-slate-500 dark:text-slate-400 hover:text-blue-500 dark:hover:text-blue-400 transition-colors">
                    <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </button>

                <div class="flex items-center gap-2 text-sm">
                    <div class="w-8 h-8 rounded-full btn-glow flex items-center justify-center text-white text-xs font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="text-slate-600 dark:text-slate-300 font-medium hidden sm:block">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </header>

        {{-- Flash --}}
        @if(session('success') || session('error'))
        <div class="px-6 pt-4">
            @if(session('success'))
            <div class="glass-blue border border-green-500/30 text-green-300 text-sm px-5 py-3 rounded-xl">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
            <div class="glass border border-red-500/30 text-red-400 text-sm px-5 py-3 rounded-xl">❌ {{ session('error') }}</div>
            @endif
        </div>
        @endif

        {{-- Content --}}
        <main class="flex-1 p-6">
            @yield('admin-content')
        </main>
    </div>
</div>
</body>
</html>
