@extends('layouts.app')

@section('content')

{{-- HERO SECTION --}}
<section class="relative overflow-hidden py-20 md:py-32">
    {{-- Background glow --}}
    <div class="absolute inset-0 hero-glow pointer-events-none"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[600px] bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full xl:w-[90%] 2xl:w-[85%] max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-0 relative z-10">
        <div class="text-center max-w-4xl mx-auto">
            <div class="inline-flex items-center gap-2 glass-blue rounded-full px-4 py-2 text-sm text-blue-300 mb-8 font-medium">
                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                {{ $settings['hero_badge'] ?? 'Stok Tersedia — Pengiriman Seluruh Indonesia' }}
            </div>

            <h1 class="font-jakarta text-5xl md:text-7xl font-extrabold text-slate-900 dark:text-white mb-6 leading-tight">
                {{ $settings['hero_title'] ?? 'Toko Komputer' }}
                <br>
                <span class="gradient-text">{{ $settings['hero_title_highlight'] ?? 'Terpercaya #1' }}</span>
            </h1>

            <p class="text-slate-500 dark:text-slate-400 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
                {{ $settings['hero_subtitle'] ?? 'Temukan laptop, PC gaming, monitor, dan aksesoris komputer terbaik dengan harga kompetitif. Produk original bergaransi resmi.' }}
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('products.index') }}" class="btn-glow text-slate-900 dark:text-white font-bold px-8 py-4 rounded-2xl text-lg inline-flex items-center gap-2">
                    {{ $settings['hero_cta_primary'] ?? '🛍️ Belanja Sekarang' }}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="#categories" class="btn-outline text-slate-900 dark:text-white font-semibold px-8 py-4 rounded-2xl text-lg inline-flex items-center gap-2 border border-blue-500/40 hover:bg-blue-500/10 transition-all">
                    {{ $settings['hero_cta_secondary'] ?? 'Lihat Kategori' }}
                </a>
            </div>

            {{-- Stats --}}
            <div class="grid grid-cols-3 gap-6 mt-16 max-w-xl mx-auto">
                <div class="glass rounded-2xl p-4 text-center">
                    <div class="text-2xl font-bold gradient-text">{{ $settings['stat_1_value'] ?? '500+' }}</div>
                    <div class="text-slate-500 dark:text-slate-400 text-xs mt-1">{{ $settings['stat_1_label'] ?? 'Produk' }}</div>
                </div>
                <div class="glass rounded-2xl p-4 text-center">
                    <div class="text-2xl font-bold gradient-text">{{ $settings['stat_2_value'] ?? '10K+' }}</div>
                    <div class="text-slate-500 dark:text-slate-400 text-xs mt-1">{{ $settings['stat_2_label'] ?? 'Pelanggan' }}</div>
                </div>
                <div class="glass rounded-2xl p-4 text-center">
                    <div class="text-2xl font-bold gradient-text">{{ $settings['stat_3_value'] ?? '4.9★' }}</div>
                    <div class="text-slate-500 dark:text-slate-400 text-xs mt-1">{{ $settings['stat_3_label'] ?? 'Rating' }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CATEGORIES --}}
<section id="categories" class="py-16">
    <div class="w-full xl:w-[90%] 2xl:w-[85%] max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-0">
        <div class="text-center mb-12">
            <h2 class="font-jakarta text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-3">Belanja per <span class="gradient-text">Kategori</span></h2>
            <p class="text-slate-500 dark:text-slate-400">Temukan produk sesuai kebutuhan Anda</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($categories as $index => $category)
            <a href="{{ route('categories.show', $category) }}"
               class="glass card-hover rounded-2xl p-5 text-center group border border-slate-200 dark:border-white/5"
               style="animation-delay: {{ $index * 0.05 }}s">
                <div class="text-4xl mb-3 group-hover:scale-110 transition-transform duration-300 drop-shadow-md">{{ $category->icon }}</div>
                <h3 class="text-slate-900 dark:text-white text-sm font-semibold mb-1">{{ $category->name }}</h3>
                <p class="text-slate-500 text-xs">{{ $category->products_count }} produk</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- FEATURED PRODUCTS --}}
<section class="py-16">
    <div class="w-full xl:w-[90%] 2xl:w-[85%] max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-0">
        <div class="flex items-center justify-between mb-12">
            <div>
                <h2 class="font-jakarta text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-2">Produk <span class="gradient-text">Unggulan</span></h2>
                <p class="text-slate-500 dark:text-slate-400">Pilihan terbaik yang direkomendasikan</p>
            </div>
            <a href="{{ route('products.index') }}" class="hidden sm:flex items-center gap-2 text-blue-400 hover:text-blue-300 transition-colors font-medium text-sm">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">
            @foreach($featuredProducts as $index => $product)
            @include('partials.product-card', ['product' => $product, 'index' => $index])
            @endforeach
        </div>
    </div>
</section>

{{-- PROMO BANNER --}}
<section class="py-8">
    <div class="w-full xl:w-[90%] 2xl:w-[85%] max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-0">
        <div class="relative overflow-hidden rounded-3xl p-8 md:p-12" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e1b4b 50%, #0f172a 100%);">
            <div class="absolute inset-0" style="background: radial-gradient(ellipse at 80% 50%, rgba(59,130,246,0.3) 0%, transparent 60%);"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <div class="text-blue-300 text-sm font-semibold mb-2 tracking-widest uppercase">
                        {{ $settings['promo_badge'] ?? '⚡ Penawaran Spesial' }}
                    </div>
                    <h2 class="font-jakarta text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-3">
                        {{ $settings['promo_title'] ?? 'Diskon hingga' }}
                        <span class="text-yellow-400">{{ $settings['promo_highlight'] ?? '30%' }}</span>
                    </h2>
                    <p class="text-blue-200 text-lg">{{ $settings['promo_subtitle'] ?? 'untuk produk pilihan kategori Laptop & PC Gaming' }}</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('categories.show', $settings['promo_link_slug'] ?? 'laptop') }}" class="btn-glow text-slate-900 dark:text-white font-bold px-8 py-4 rounded-2xl text-lg inline-block">
                        {{ $settings['promo_cta'] ?? 'Cek Sekarang →' }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- LATEST PRODUCTS --}}
<section class="py-16">
    <div class="w-full xl:w-[90%] 2xl:w-[85%] max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-0">
        <div class="text-center mb-12">
            <h2 class="font-jakarta text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-3">Produk <span class="gradient-text">Terbaru</span></h2>
            <p class="text-slate-500 dark:text-slate-400">Baru saja ditambahkan ke katalog kami</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">
            @foreach($latestProducts as $index => $product)
            @include('partials.product-card', ['product' => $product, 'index' => $index])
            @endforeach
        </div>
    </div>
</section>

{{-- WHY US --}}
<section class="py-16">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
        <div class="text-center mb-12">
            <h2 class="font-jakarta text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-3">
                {{ $settings['why_us_title'] ?? 'Mengapa' }}
                <span class="gradient-text">{{ $settings['why_us_highlight'] ?? 'TechnoStore?' }}</span>
            </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
            $features = [];
            for ($i = 1; $i <= 6; $i++) {
                $features[] = [
                    'icon'  => $settings['feature_'.$i.'_icon']  ?? '',
                    'title' => $settings['feature_'.$i.'_title'] ?? '',
                    'desc'  => $settings['feature_'.$i.'_desc']  ?? '',
                ];
            }
            @endphp
            @foreach($features as $index => $feature)
            @if($feature['title'])
            <div class="glass card-hover rounded-2xl p-6 border border-slate-200 dark:border-white/5" style="animation-delay: {{ $index * 0.1 }}s">
                <div class="text-4xl mb-4 drop-shadow-md">{{ $feature['icon'] }}</div>
                <h3 class="text-slate-900 dark:text-white font-semibold text-lg mb-2">{{ $feature['title'] }}</h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">{{ $feature['desc'] }}</p>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>

@if(isset($testimonials) && $testimonials->count() > 0)
{{-- TESTIMONIALS --}}
<section class="py-16">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
        <div class="text-center mb-12">
            <h2 class="font-jakarta text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-3">
                Apa Kata <span class="gradient-text">Pelanggan?</span>
            </h2>
            <p class="text-slate-500 dark:text-slate-400">Pengalaman nyata dari pelanggan yang telah berbelanja di toko kami</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($testimonials as $index => $testimonial)
            <div class="glass card-hover rounded-3xl p-8 border border-slate-200 dark:border-white/5 relative flex flex-col justify-between" style="animation-delay: {{ $index * 0.1 }}s">
                {{-- Quote Icon --}}
                <div class="absolute top-6 right-6 text-slate-200 dark:text-white/5 opacity-50">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z"/>
                    </svg>
                </div>

                {{-- Rating & Content --}}
                <div class="relative z-10 mb-6">
                    <div class="flex items-center text-yellow-400 text-lg mb-4">
                        {!! str_repeat('★', $testimonial->rating) !!}
                        @if($testimonial->rating < 5)
                            <span class="text-slate-300 dark:text-slate-600">{!! str_repeat('★', 5 - $testimonial->rating) !!}</span>
                        @endif
                    </div>
                    <p class="text-slate-700 dark:text-slate-300 text-base leading-relaxed italic">"{{ $testimonial->content }}"</p>
                </div>

                {{-- Author --}}
                <div class="relative z-10 flex items-center gap-4 mt-auto">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                        {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="text-slate-900 dark:text-white font-bold">{{ $testimonial->name }}</h4>
                        @if($testimonial->role_or_location)
                            <p class="text-slate-500 text-sm">{{ $testimonial->role_or_location }}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection
