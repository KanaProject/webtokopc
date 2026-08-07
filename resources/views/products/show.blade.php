@extends('layouts.app')

@section('content')
<div class="max-w-[1536px] mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-slate-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-blue-400 transition-colors">Beranda</a>
        <span>›</span>
        <a href="{{ route('products.index') }}" class="hover:text-blue-400 transition-colors">Produk</a>
        <span>›</span>
        <a href="{{ route('categories.show', $product->category) }}" class="hover:text-blue-400 transition-colors">{{ $product->category->name }}</a>
        <span>›</span>
        <span class="text-slate-700 dark:text-slate-300">{{ Str::limit($product->name, 40) }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-16">

        {{-- Product Image --}}
        <div>
            <div class="glass rounded-2xl overflow-hidden aspect-square flex items-center justify-center bg-gradient-to-br from-slate-800 to-slate-900 mb-4">
                @if($product->image)
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-4">
                @else
                <div class="text-9xl">{{ $product->category->icon ?? '💻' }}</div>
                @endif
            </div>
        </div>

        {{-- Product Info --}}
        <div>
            {{-- Category badge --}}
            <div class="flex items-center gap-2 mb-3">
                <a href="{{ route('categories.show', $product->category) }}" class="glass-blue text-blue-400 text-xs font-semibold px-3 py-1 rounded-full">{{ $product->category->name }}</a>
                @if($product->brand)
                <span class="glass text-slate-500 dark:text-slate-400 text-xs font-medium px-3 py-1 rounded-full">{{ $product->brand }}</span>
                @endif
                @if($product->is_featured)
                <span class="bg-yellow-500/20 text-yellow-300 border border-yellow-500/30 text-xs font-bold px-3 py-1 rounded-full">⭐ Featured</span>
                @endif
            </div>

            <h1 class="font-jakarta text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-4 leading-tight">{{ $product->name }}</h1>

            {{-- Rating --}}
            @if($product->rating_count > 0)
            <div class="flex items-center gap-3 mb-5">
                <div class="flex">
                    @for($i = 1; $i <= 5; $i++)
                    <svg class="w-5 h-5 {{ $i <= round($product->rating) ? 'text-yellow-400' : 'text-slate-600' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <span class="text-slate-700 dark:text-slate-300 text-sm font-medium">{{ $product->rating }}/5</span>
                <span class="text-slate-500 text-sm">({{ $product->rating_count }} ulasan)</span>
            </div>
            @endif

            {{-- Price --}}
            <div class="glass rounded-2xl p-5 mb-6">
                <div class="flex items-baseline gap-3 mb-2">
                    <span class="text-3xl font-bold text-blue-400">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @if($product->original_price && $product->original_price > $product->price)
                    @php $disc = (int) round((($product->original_price - $product->price) / $product->original_price) * 100); @endphp
                    <span class="text-slate-500 text-lg line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full text-slate-900 dark:text-white" style="background: linear-gradient(135deg, #EF4444, #F97316)">-{{ $disc }}%</span>
                    @endif
                </div>

                {{-- Stock --}}
                <div class="flex items-center gap-2">
                    @if($product->stock > 10)
                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                    <span class="text-green-400 text-sm font-medium">Stok Tersedia ({{ $product->stock }} unit)</span>
                    @elseif($product->stock > 0)
                    <span class="w-2 h-2 rounded-full bg-orange-400"></span>
                    <span class="text-orange-400 text-sm font-medium">Stok Terbatas ({{ $product->stock }} unit)</span>
                    @else
                    <span class="w-2 h-2 rounded-full bg-red-400"></span>
                    <span class="text-red-400 text-sm font-medium">Stok Habis</span>
                    @endif
                </div>
            </div>

            {{-- Add to Cart --}}
            @if($product->stock > 0)
            <form action="{{ route('cart.add', $product) }}" method="POST" class="flex gap-3 mb-6">
                @csrf
                <div class="flex items-center glass rounded-xl overflow-hidden border border-slate-300 dark:border-white/10">
                    <button type="button" onclick="changeQty(-1)" class="px-4 py-3 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:text-white hover:bg-slate-200 dark:bg-white/10 transition-colors font-bold">−</button>
                    <input type="number" name="quantity" id="qty" value="1" min="1" max="{{ $product->stock }}"
                           class="w-14 text-center bg-transparent text-slate-900 dark:text-white text-sm font-semibold focus:outline-none">
                    <button type="button" onclick="changeQty(1)" class="px-4 py-3 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:text-white hover:bg-slate-200 dark:bg-white/10 transition-colors font-bold">+</button>
                </div>
                <button type="submit" class="flex-1 btn-glow text-slate-900 dark:text-white font-bold py-3 rounded-xl flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Tambah ke Keranjang
                </button>
            </form>
            @else
            <button disabled class="w-full mb-6 bg-slate-700/50 text-slate-500 font-bold py-3 rounded-xl cursor-not-allowed">Stok Habis</button>
            @endif

            {{-- Description --}}
            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-6">{{ $product->description }}</p>

            {{-- Specs --}}
            @if($product->specs && count($product->specs) > 0)
            <div class="glass rounded-2xl p-5">
                <h3 class="text-slate-900 dark:text-white font-semibold mb-4">📋 Spesifikasi</h3>
                <div class="space-y-2">
                    @foreach($product->specs as $key => $value)
                    <div class="flex gap-3 py-2 border-b border-slate-200 dark:border-white/5 last:border-0">
                        <span class="text-slate-500 dark:text-slate-400 text-sm w-32 flex-shrink-0 font-medium">{{ $key }}</span>
                        <span class="text-slate-900 dark:text-white text-sm">{{ $value }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Long description --}}
    @if($product->long_description)
    <div class="glass rounded-2xl p-8 mb-12">
        <h2 class="text-slate-900 dark:text-white font-jakarta font-bold text-xl mb-4">Deskripsi Lengkap</h2>
        <div class="text-slate-500 dark:text-slate-400 leading-relaxed text-sm prose-invert">{!! nl2br(e($product->long_description)) !!}</div>
    </div>
    @endif

    {{-- Related Products --}}
    @if($related->count() > 0)
    <div>
        <h2 class="font-jakarta text-2xl font-bold text-slate-900 dark:text-white mb-6">Produk <span class="gradient-text">Terkait</span></h2>
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach($related as $index => $rProduct)
            @include('partials.product-card', ['product' => $rProduct, 'index' => $index])
            @endforeach
        </div>
    </div>
    @endif
</div>

<script>
function changeQty(delta) {
    const input = document.getElementById('qty');
    const max = parseInt(input.getAttribute('max'));
    const val = parseInt(input.value) + delta;
    input.value = Math.max(1, Math.min(max, val));
}
</script>
@endsection
