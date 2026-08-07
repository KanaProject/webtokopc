<div class="product-card bg-white dark:bg-slate-900 hover:shadow-xl transition-all duration-300 flex flex-col group relative"
     style="{{ isset($index) ? 'animation-delay: ' . ($index * 0.05) . 's' : '' }}">

    {{-- Badges (Absolute) --}}
    <div class="absolute top-2 left-2 z-10 flex flex-col gap-1">
        @if($product->is_featured)
        <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-yellow-500 text-white shadow-sm">⭐ Featured</span>
        @endif
        @if($product->stock <= 5 && $product->stock > 0)
        <span class="text-[10px] font-medium px-2 py-0.5 rounded bg-orange-500 text-white shadow-sm">Sisa {{ $product->stock }}</span>
        @endif
    </div>

    {{-- Image --}}
    <a href="{{ route('products.show', $product) }}" class="block relative overflow-hidden bg-white dark:bg-slate-800 aspect-square p-4">
        @if($product->image)
        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
             class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500">
        @else
        <div class="w-full h-full flex items-center justify-center text-5xl">
            {{ $product->category->icon ?? '💻' }}
        </div>
        @endif
        
        @if($product->stock == 0)
        <div class="absolute inset-0 bg-white/70 dark:bg-black/70 flex items-center justify-center">
            <span class="text-white font-bold text-xs bg-red-600 px-3 py-1 rounded">Habis</span>
        </div>
        @endif
    </a>

    {{-- Info --}}
    <div class="p-3 flex flex-col flex-1 border-t border-slate-100 dark:border-slate-800">
        <a href="{{ route('products.show', $product) }}" class="text-slate-800 dark:text-slate-200 font-medium text-[13px] leading-tight mb-2 hover:text-blue-600 dark:hover:text-blue-400 transition-colors line-clamp-2" title="{{ $product->name }}">
            {{ $product->name }}
        </a>

        {{-- Rating --}}
        @if($product->rating_count > 0)
        <div class="flex items-center gap-1 mb-2">
            <div class="flex">
                @for($i = 1; $i <= 5; $i++)
                <svg class="w-3 h-3 {{ $i <= round($product->rating) ? 'text-yellow-400' : 'text-slate-300 dark:text-slate-600' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                @endfor
            </div>
            <span class="text-[10px] text-slate-500">({{ $product->rating_count }})</span>
        </div>
        @else
        <div class="h-4 mb-2"></div>
        @endif

        {{-- Price --}}
        <div class="mt-auto">
            @if($product->original_price && $product->original_price > $product->price)
            <div class="flex items-center gap-1.5 mb-0.5">
                <span class="text-slate-400 dark:text-slate-500 text-[11px] line-through">Rp {{ number_format($product->original_price, 0, ',', '.') }}</span>
                @php $disc = (int) round((($product->original_price - $product->price) / $product->original_price) * 100); @endphp
                <span class="text-[10px] font-bold px-1 py-0.5 rounded bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400">-{{ $disc }}%</span>
            </div>
            @endif
            <div class="text-green-600 dark:text-green-400 font-bold text-base mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</div>

            {{-- Add to cart --}}
            @if($product->stock > 0)
            <form action="{{ route('cart.add', $product) }}" method="POST">
                @csrf
                <button type="submit"
                        class="w-full bg-slate-100 dark:bg-slate-800 hover:bg-green-500 hover:text-white text-green-600 dark:text-green-400 dark:hover:text-white text-xs font-bold py-2 rounded flex items-center justify-center gap-1.5 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Beli
                </button>
            </form>
            @else
            <button disabled class="w-full bg-slate-200 dark:bg-slate-800 text-slate-400 dark:text-slate-600 text-xs font-bold py-2 rounded cursor-not-allowed">
                Habis
            </button>
            @endif
        </div>
    </div>
</div>
