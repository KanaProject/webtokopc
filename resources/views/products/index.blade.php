@extends('layouts.app')

@section('content')
<div class="w-full xl:w-[90%] 2xl:w-[85%] max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-0 py-10">
    <div class="flex flex-col lg:flex-row gap-8">

        {{-- SIDEBAR FILTER --}}
        <aside class="lg:w-72 xl:w-80 flex-shrink-0" x-data="{ open: false }">
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
                        
                        {{-- Mobile: Dropdown --}}
                        <div class="lg:hidden">
                            <select name="category" onchange="this.form.submit()" class="w-full bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-500/50">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->icon }} {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Desktop: Radio Buttons (List) --}}
                        <div class="hidden lg:block space-y-2">
                            <label class="flex items-center gap-3 p-2 rounded-xl cursor-pointer transition-colors {{ !request('category') ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400' : 'hover:bg-slate-100 dark:hover:bg-white/5 text-slate-700 dark:text-slate-300' }}">
                                <input type="radio" name="category" value="" onchange="this.form.submit()" class="hidden" {{ !request('category') ? 'checked' : '' }}>
                                <span class="w-4 h-4 rounded-full border-2 flex items-center justify-center {{ !request('category') ? 'border-blue-500' : 'border-slate-300 dark:border-slate-600' }}">
                                    @if(!request('category')) <span class="w-2 h-2 rounded-full bg-blue-500"></span> @endif
                                </span>
                                <span class="text-sm font-medium">Semua Kategori</span>
                            </label>

                            @foreach($categories as $cat)
                            <label class="flex items-center gap-3 p-2 rounded-xl cursor-pointer transition-colors {{ request('category') === $cat->slug ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400' : 'hover:bg-slate-100 dark:hover:bg-white/5 text-slate-700 dark:text-slate-300' }}">
                                <input type="radio" name="category" value="{{ $cat->slug }}" onchange="this.form.submit()" class="hidden" {{ request('category') === $cat->slug ? 'checked' : '' }}>
                                <span class="w-4 h-4 rounded-full border-2 flex items-center justify-center {{ request('category') === $cat->slug ? 'border-blue-500' : 'border-slate-300 dark:border-slate-600' }}">
                                    @if(request('category') === $cat->slug) <span class="w-2 h-2 rounded-full bg-blue-500"></span> @endif
                                </span>
                                <span class="text-sm font-medium">{{ $cat->icon }} {{ $cat->name }}</span>
                            </label>
                            @endforeach
                        </div>
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
            <div class="bg-slate-200 dark:bg-slate-700 border-2 border-red-500 dark:border-blue-500 rounded-xl overflow-hidden">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-[1px]">
                    @foreach($products as $index => $product)
                    @include('partials.product-card', ['product' => $product, 'index' => $index])
                    @endforeach
                </div>
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
