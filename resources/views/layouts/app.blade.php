<!DOCTYPE html>
<html lang="id" class="scroll-smooth" x-data="{ darkMode: false }" x-init="darkMode = document.documentElement.classList.contains('dark'); $watch('darkMode', val => { if(val) { document.documentElement.classList.add('dark'); localStorage.theme = 'dark'; } else { document.documentElement.classList.remove('dark'); localStorage.theme = 'light'; } })">
@php
    $storeSettings = \App\Models\SiteSetting::allAsArray();
    $storeName = $storeSettings['store_name'] ?? 'TechnoStore';
    $storeLogo = $storeSettings['store_logo'] ?? null;
    $storeTagline = $storeSettings['store_tagline'] ?? 'Toko Komputer Terpercaya';
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $metaDescription ?? $storeName . ' - ' . $storeTagline }}">
    <title>{{ isset($title) ? $title . ' — ' . $storeName : $storeName . ' — ' . $storeTagline }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>💻</text></svg>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-primary); color: var(--text-primary); min-height: 100vh; transition: background-color 0.3s, color 0.3s; }
        .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255,255,255,0.7); backdrop-filter: blur(12px); border: 1px solid rgba(0,0,0,0.05); }
        .dark .glass { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); }
        .glass-blue { background: rgba(59,130,246,0.15); backdrop-filter: blur(12px); border: 1px solid rgba(59,130,246,0.3); }
        .dark .glass-blue { background: rgba(59,130,246,0.08); border: 1px solid rgba(59,130,246,0.2); }
        .gradient-text { background: linear-gradient(135deg, #3B82F6 0%, #06B6D4 50%, #8B5CF6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(59,130,246,0.2); border-color: rgba(59,130,246,0.4); }
        .btn-glow { background: linear-gradient(135deg, #3B82F6, #06B6D4); box-shadow: 0 0 20px rgba(59,130,246,0.4); transition: all 0.3s ease; }
        .btn-glow:hover { box-shadow: 0 0 35px rgba(59,130,246,0.7); transform: translateY(-1px); }
        .btn-outline { border: 1px solid rgba(59,130,246,0.4); color: #3B82F6; transition: all 0.3s ease; }
        .btn-outline:hover { background: rgba(59,130,246,0.1); border-color: #3B82F6; }
        .nav-link { transition: color 0.2s ease; }
        .nav-link:hover { color: #3B82F6; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-primary); }
        ::-webkit-scrollbar-thumb { background: var(--accent-blue); border-radius: 3px; }
        .product-card { animation: fadeInUp 0.5s ease both; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .toast { animation: slideIn 0.4s ease; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        .hero-glow { background: radial-gradient(ellipse at center, rgba(59,130,246,0.15) 0%, transparent 70%); }

        /* ===== LIGHT MODE OVERRIDES ===== */
        html:not(.dark) body {
            color: #0F172A;
        }
        /* Nav links */
        html:not(.dark) .nav-link {
            color: #1E293B !important;
        }
        html:not(.dark) .nav-link:hover {
            color: #3B82F6 !important;
        }
        /* Semua teks slate-* di navbar & footer menjadi gelap */
        html:not(.dark) nav a,
        html:not(.dark) nav button:not(.btn-glow),
        html:not(.dark) nav span:not(.gradient-text) {
            color: #1E293B;
        }
        /* Dropdown kategori di navbar */
        html:not(.dark) nav .glass a {
            color: #334155 !important;
        }
        html:not(.dark) nav .glass a:hover {
            color: #1E293B !important;
            background: rgba(59,130,246,0.08) !important;
        }
        /* Footer teks */
        html:not(.dark) footer {
            background: #F1F5F9 !important;
            border-top-color: rgba(0,0,0,0.08) !important;
        }
        html:not(.dark) footer h4,
        html:not(.dark) footer a,
        html:not(.dark) footer p,
        html:not(.dark) footer li {
            color: #334155 !important;
        }
        html:not(.dark) footer a:hover {
            color: #3B82F6 !important;
        }
        html:not(.dark) footer hr {
            border-color: rgba(0,0,0,0.08) !important;
        }
        /* Search input */
        html:not(.dark) nav input[type="text"] {
            background: rgba(0,0,0,0.04) !important;
            border-color: rgba(0,0,0,0.12) !important;
            color: #1E293B !important;
        }
        html:not(.dark) nav input[type="text"]::placeholder {
            color: #94A3B8 !important;
        }
        /* Icon warna di navbar */
        html:not(.dark) nav svg {
            color: #475569;
        }
        html:not(.dark) nav svg:hover {
            color: #3B82F6;
        }
        /* User dropdown */
        html:not(.dark) .glass-blue {
            background: rgba(59,130,246,0.1) !important;
        }
        html:not(.dark) nav .glass-blue span,
        html:not(.dark) nav .glass-blue button {
            color: #1E293B !important;
        }
        html:not(.dark) nav .glass {
            background: rgba(255,255,255,0.85) !important;
            border-color: rgba(0,0,0,0.08) !important;
        }
        /* Mobile menu */
        html:not(.dark) nav [x-show="mobileOpen"] {
            background: #F8FAFC !important;
            border-top-color: rgba(0,0,0,0.08) !important;
        }
        html:not(.dark) nav [x-show="mobileOpen"] a {
            color: #334155 !important;
        }
    </style>
</head>
<body class="antialiased">

    <!-- NAVBAR -->
    <nav class="sticky top-0 z-50 glass border-b border-blue-500/10" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    @if($storeLogo)
                        <img src="{{ Storage::url($storeLogo) }}" alt="{{ $storeName }}" class="h-9 w-auto object-contain">
                    @else
                        <div class="w-9 h-9 rounded-xl btn-glow flex items-center justify-center text-lg font-bold text-white">{{ strtoupper(substr($storeName, 0, 1)) }}</div>
                    @endif
                    <span class="font-jakarta font-extrabold text-xl text-slate-900 dark:text-white">{{ $storeName }}</span>
                </a>

                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('home') }}" class="nav-link text-slate-300 text-sm font-medium">Beranda</a>
                    <a href="{{ route('products.index') }}" class="nav-link text-slate-300 text-sm font-medium">Produk</a>
                    <div class="relative" x-data="{ open: false }" @mouseenter="open=true" @mouseleave="open=false">
                        <button class="nav-link text-slate-300 text-sm font-medium flex items-center gap-1">
                            Kategori <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-transition class="absolute top-full left-0 mt-2 w-52 glass rounded-xl border border-blue-500/20 py-2 shadow-2xl">
                            @foreach(\App\Models\Category::where('is_active', true)->orderBy('sort_order')->get() as $cat)
                            <a href="{{ route('categories.show', $cat) }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-300 hover:text-white hover:bg-blue-500/10 transition-colors">
                                <span>{{ $cat->icon }}</span> {{ $cat->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <form action="{{ route('products.index') }}" method="GET" class="hidden md:flex">
                        <div class="relative">
                            <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                                   class="bg-white/5 border border-white/10 rounded-xl pl-4 pr-10 py-2 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-blue-500/50 w-48 focus:w-60 transition-all duration-300">
                            <button type="submit" class="absolute right-3 top-2.5 text-slate-400 hover:text-blue-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </button>
                        </div>
                    </form>

                    <a href="{{ route('cart.index') }}" class="relative p-2 text-slate-500 dark:text-slate-400 hover:text-blue-500 dark:hover:text-blue-400 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        @php $cartCount = array_sum(array_column(session('cart', []), 'quantity')); @endphp
                        @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-blue-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" class="p-2 text-slate-500 dark:text-slate-400 hover:text-blue-500 dark:hover:text-blue-400 transition-colors">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>

                    @auth
                    <div class="relative" x-data="{ open: false }" @click.outside="open=false">
                        <button @click="open=!open" class="flex items-center gap-2 glass-blue rounded-xl px-3 py-2 text-sm text-white">
                            <div class="w-7 h-7 rounded-full btn-glow flex items-center justify-center text-xs font-bold">{{ substr(auth()->user()->name, 0, 1) }}</div>
                            <span class="hidden sm:block font-medium">{{ Str::words(auth()->user()->name, 1, '') }}</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" x-transition class="absolute right-0 top-full mt-2 w-48 glass rounded-xl border border-blue-500/20 py-2 shadow-2xl">
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-blue-400 hover:bg-blue-500/10 transition-colors">⚙️ Admin Panel</a>
                            @endif
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-300 hover:bg-white/5 transition-colors">👤 Profil</a>
                            <a href="{{ route('orders.index') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-300 hover:bg-white/5 transition-colors">📦 Pesanan Saya</a>
                            <hr class="border-white/10 my-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-red-400 hover:bg-red-500/10 transition-colors">🚪 Keluar</button>
                            </form>
                        </div>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="text-sm text-slate-300 hover:text-white transition-colors font-medium">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-glow text-white text-sm font-semibold px-4 py-2 rounded-xl">Daftar</a>
                    @endauth

                    <button @click="mobileOpen=!mobileOpen" class="md:hidden p-2 text-slate-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="mobileOpen" x-transition class="md:hidden border-t border-white/5 px-4 py-4 space-y-2 bg-slate-900/95">
            <a href="{{ route('home') }}" class="block text-slate-300 text-sm py-2 hover:text-blue-400">Beranda</a>
            <a href="{{ route('products.index') }}" class="block text-slate-300 text-sm py-2 hover:text-blue-400">Semua Produk</a>
            @foreach(\App\Models\Category::where('is_active', true)->orderBy('sort_order')->get() as $cat)
            <a href="{{ route('categories.show', $cat) }}" class="block text-slate-400 text-sm py-2 pl-4 hover:text-blue-400">{{ $cat->icon }} {{ $cat->name }}</a>
            @endforeach
        </div>
    </nav>

    <!-- FLASH MESSAGES -->
    @if(session('success') || session('error'))
    <div class="fixed top-20 right-4 z-50 max-w-sm space-y-2" x-data>
        @if(session('success'))
        <div class="toast glass-blue border border-green-500/30 text-green-300 text-sm px-5 py-4 rounded-xl flex items-center gap-3 shadow-2xl">
            ✅ {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="toast glass border border-red-500/30 text-red-400 text-sm px-5 py-4 rounded-xl flex items-center gap-3 shadow-2xl">
            ❌ {{ session('error') }}
        </div>
        @endif
    </div>
    <script>setTimeout(() => { document.querySelectorAll('.toast').forEach(t => { if(t.parentElement) t.parentElement.remove(); }); }, 4000);</script>
    @endif

    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="mt-20 border-t border-white/5 bg-slate-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                        @if($storeLogo)
                            <img src="{{ Storage::url($storeLogo) }}" alt="{{ $storeName }}" class="h-9 w-auto object-contain">
                        @else
                            <div class="w-9 h-9 rounded-xl btn-glow flex items-center justify-center text-lg font-bold text-white">{{ strtoupper(substr($storeName, 0, 1)) }}</div>
                        @endif
                        <span class="font-jakarta font-extrabold text-xl text-white">{{ $storeName }}</span>
                    </a>
                    <p class="text-slate-400 text-sm leading-relaxed">{{ $storeSettings['store_description'] ?? 'Toko komputer terpercaya dengan produk original bergaransi resmi.' }}</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Kategori</h4>
                    <ul class="space-y-2">
                        @foreach(\App\Models\Category::where('is_active', true)->orderBy('sort_order')->take(5)->get() as $cat)
                        <li><a href="{{ route('categories.show', $cat) }}" class="text-slate-400 text-sm hover:text-blue-400 transition-colors">{{ $cat->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Akun</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('login') }}" class="text-slate-400 text-sm hover:text-blue-400 transition-colors">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="text-slate-400 text-sm hover:text-blue-400 transition-colors">Daftar</a></li>
                        @auth
                        <li><a href="{{ route('orders.index') }}" class="text-slate-400 text-sm hover:text-blue-400 transition-colors">Pesanan Saya</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2.5 text-slate-400 text-sm">
                        @if($storeSettings['store_address'] ?? null)<li>📍 {{ $storeSettings['store_address'] }}</li>@endif
                        @if($storeSettings['store_phone'] ?? null)<li>📞 {{ $storeSettings['store_phone'] }}</li>@endif
                        @if($storeSettings['store_email'] ?? null)<li>✉️ {{ $storeSettings['store_email'] }}</li>@endif
                    </ul>
                </div>
            </div>
            <hr class="border-white/5 mt-10 mb-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-slate-500 text-sm">
                <p>© {{ date('Y') }} {{ $storeName }}. Semua hak cipta dilindungi.</p>
                <p>Dibuat dengan ❤️ menggunakan Laravel</p>
            </div>
        </div>
    </footer>
</body>
</html>
