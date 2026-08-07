@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col lg:flex-row gap-8">

        {{-- SIDEBAR FILTER --}}
        <aside class="lg:w-64 flex-shrink-0" x-data="{ open: false }">
            <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5 sticky top-24">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-slate-900 dark:text-white font-semibold text-lg">Filter</h3>
                    @if(request()->anyFilled(['category', 'min_price', 'max_price', 'search']))
                    <a href="{{ route('products.index') }}" class="text-xs text-red-400 hover:text-red-300">Reset</a>
                    @endif
                </div>

                <form action="{{ route('products.index') }}" method="GET" id="filter-form">
                    @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    {{-- Kategori --}}
                    <div class="mb-6">
                        <h4 class="text-slate-700 dark:text-slate-300 text-sm font-semibold mb-3">Kategori</h4>
                        <select name="category" onchange="this.form.submit()" class="w-full bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-500/50">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                                {{ $cat->icon }} {{ $cat->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Harga --}}
                    <div class="mb-6">
                        <h4 class="text-slate-700 dark:text-slate-300 text-sm font-semibold mb-3">Rentang Harga</h4>
                        <div class="flex items-center gap-2 lg:flex-col lg:items-stretch lg:gap-3">
                            <input type="number" name="min_price" placeholder="Harga min" value="{{ request('min_price') }}"
                                   class="w-full bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl px-3 py-2 text-sm text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:border-blue-500/50">
                            <span class="text-slate-400 text-sm font-medium lg:hidden">s/d</span>
                            <input type="number" name="max_price" placeholder="Harga maks" value="{{ request('max_price') }}"
                                   class="w-full bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl px-3 py-2 text-sm text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:border-blue-500/50">
                        </div>
                    </div>

                    <button type="submit" class="w-full btn-glow text-slate-900 dark:text-white text-sm font-semibold py-2.5 rounded-xl">
                        Terapkan Filter
                    </button>
                </form>
            </div>
        </aside>

        {{-- PRODUCT GRID --}}
        <div class="flex-1">
            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-slate-900 dark:text-white font-jakarta font-bold text-2xl">
                        {{ $selectedCategory ? $selectedCategory->name : 'Semua Produk' }}
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">{{ $products->total() }} produk ditemukan</p>
                </div>

                {{-- Sort --}}
                <div class="flex items-center gap-2">
                    <span class="text-slate-500 dark:text-slate-400 text-sm">Urutkan:</span>
                    <select name="sort" onchange="window.location.href='{{ route('products.index') }}?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), sort: this.value})"
                            class="bg-white dark:bg-slate-800 border border-slate-300 dark:border-white/10 rounded-xl px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-500/50">
                        <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                        <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                        <option value="popular" {{ $sort === 'popular' ? 'selected' : '' }}>Terpopuler</option>
                        <option value="rating" {{ $sort === 'rating' ? 'selected' : '' }}>Rating Terbaik</option>
                    </select>
                </div>
            </div>

            @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                @foreach($products as $index => $product)
                @include('partials.product-card', ['product' => $product, 'index' => $index])
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $products->links('partials.pagination') }}
            </div>
            @endif

            @else
            <div class="text-center py-24">
                <div class="text-6xl mb-4">🔍</div>
                <h3 class="text-slate-900 dark:text-white font-semibold text-xl mb-2">Produk tidak ditemukan</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6">Coba ubah filter atau kata kunci pencarian Anda.</p>
                <a href="{{ route('products.index') }}" class="btn-glow text-slate-900 dark:text-white font-semibold px-6 py-3 rounded-xl inline-block">Reset Pencarian</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
