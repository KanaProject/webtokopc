<div class="product-card glass card-hover rounded-2xl overflow-hidden border border-slate-200 dark:border-white/5 flex flex-col"
     style="{{ isset($index) ? 'animation-delay: ' . ($index * 0.08) . 's' : '' }}">

    {{-- Image --}}
    <a href="{{ route('products.show', $product) }}" class="block relative overflow-hidden bg-gradient-to-br from-slate-800 to-slate-900 aspect-square">
        @if($product->image)
        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
             class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
        @else
        <div class="w-full h-full flex items-center justify-center text-6xl">
            {{ $product->category->icon ?? '💻' }}
        </div>
        @endif

        {{-- Badges --}}
        <div class="absolute top-3 left-3 flex flex-col gap-1.5">
            @if($product->is_featured)
            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-yellow-500/20 text-yellow-300 border border-yellow-500/30">⭐ Featured</span>
            @endif
            @if($product->original_price && $product->original_price > $product->price)
            @php $disc = (int) round((($product->original_price - $product->price) / $product->original_price) * 100); @endphp
            <span class="text-xs font-bold px-2.5 py-1 rounded-full text-slate-900 dark:text-white" style="background: linear-gradient(135deg, #EF4444, #F97316)">-{{ $disc }}%</span>
            @endif
        </div>

        @if($product->stock <= 5 && $product->stock > 0)
        <div class="absolute bottom-3 left-3">
            <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-orange-500/20 text-orange-300 border border-orange-500/30">Stok Terbatas</span>
        </div>
        @elseif($product->stock == 0)
        <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
            <span class="text-slate-900 dark:text-white font-bold text-sm bg-red-600/80 px-4 py-2 rounded-xl">Habis</span>
        </div>
        @endif
    </a>

    {{-- Info --}}
    <div class="p-4 flex flex-col flex-1">
        <div class="text-xs text-blue-400 font-medium mb-1">{{ $product->category->name ?? '' }} • {{ $product->brand }}</div>
        <a href="{{ route('products.show', $product) }}" class="text-slate-900 dark:text-white font-semibold text-sm leading-snug mb-2 hover:text-blue-300 transition-colors line-clamp-2">
            {{ $product->name }}
        </a>

        {{-- Rating --}}
        @if($product->rating_count > 0)
        <div class="flex items-center gap-1 mb-3">
            <div class="flex">
                @for($i = 1; $i <= 5; $i++)
                <svg class="w-3.5 h-3.5 {{ $i <= round($product->rating) ? 'text-yellow-400' : 'text-slate-600' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                @endfor
            </div>
            <span class="text-xs text-slate-500">({{ $product->rating_count }})</span>
        </div>
        @endif

        {{-- Price --}}
        <div class="mt-auto">
            <div class="flex items-baseline gap-2 mb-3">
                <span class="text-blue-400 font-bold text-base">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @if($product->original_price)
                <span class="text-slate-500 text-xs line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                @endif
            </div>

            {{-- Add to cart --}}
            @if($product->stock > 0)
            <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf
                <button type="submit" id="add-to-cart-{{ $product->id }}"
                        class="w-full btn-glow text-slate-900 dark:text-white text-xs font-bold py-2.5 rounded-xl flex items-center justify-center gap-2 hover:opacity-90">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Tambah ke Keranjang
                </button>
            </form>
            @else
            <button disabled class="w-full bg-slate-700/50 text-slate-500 text-xs font-bold py-2.5 rounded-xl cursor-not-allowed">
                Stok Habis
            </button>
            @endif
        </div>
    </div>
</div>
