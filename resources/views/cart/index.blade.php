@extends('layouts.app')

@section('content')
<div class="w-full xl:w-[90%] 2xl:w-[85%] max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-0 py-10">
    <h1 class="font-jakarta text-3xl font-bold text-slate-900 dark:text-white mb-8">🛒 Keranjang Belanja</h1>

    @if(count($cart) > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Cart Items --}}
        <div class="lg:col-span-2 space-y-4">
            @foreach($cart as $id => $item)
            <div class="glass rounded-2xl p-5 border border-slate-200 dark:border-white/5 flex gap-4">
                {{-- Image --}}
                <div class="w-20 h-20 flex-shrink-0 glass rounded-xl overflow-hidden flex items-center justify-center bg-white dark:bg-slate-800">
                    @if($item['image'])
                    <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                    @else
                    <span class="text-2xl">💻</span>
                    @endif
                </div>

                <div class="flex-1 min-w-0">
                    <a href="{{ route('products.show', $item['slug']) }}" class="text-slate-900 dark:text-white font-semibold text-sm hover:text-blue-300 transition-colors line-clamp-2">{{ $item['name'] }}</a>
                    <div class="text-blue-400 font-bold text-base mt-1">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>

                    <div class="flex items-center justify-between mt-3">
                        {{-- Qty control --}}
                        <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                            @csrf @method('PATCH')
                            <div class="flex items-center glass rounded-xl overflow-hidden border border-slate-300 dark:border-white/10">
                                <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}"
                                        class="px-3 py-1.5 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:text-white hover:bg-slate-200 dark:bg-white/10 transition-colors text-lg font-bold">−</button>
                                <span class="px-4 py-1.5 text-slate-900 dark:text-white text-sm font-semibold">{{ $item['quantity'] }}</span>
                                <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                                        class="px-3 py-1.5 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:text-white hover:bg-slate-200 dark:bg-white/10 transition-colors text-lg font-bold">+</button>
                            </div>
                        </form>

                        <div class="flex items-center gap-3">
                            <span class="text-slate-700 dark:text-slate-300 text-sm font-medium">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 transition-colors p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-400 hover:text-red-300 text-sm transition-colors">🗑️ Kosongkan Keranjang</button>
            </form>
        </div>

        {{-- Summary --}}
        <div class="lg:col-span-1">
            <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5 sticky top-24">
                <h2 class="text-slate-900 dark:text-white font-semibold text-lg mb-5">Ringkasan Pesanan</h2>

                <div class="space-y-3 mb-5">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500 dark:text-slate-400">Subtotal</span>
                        <span class="text-slate-900 dark:text-white">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500 dark:text-slate-400">Ongkir (estimasi)</span>
                        <span class="text-slate-900 dark:text-white">Rp 25.000</span>
                    </div>
                </div>

                <hr class="border-slate-300 dark:border-white/10 mb-5">

                <div class="flex justify-between mb-6">
                    <span class="text-slate-900 dark:text-white font-semibold">Total</span>
                    <span class="text-blue-400 font-bold text-lg">Rp {{ number_format($total + 25000, 0, ',', '.') }}</span>
                </div>

                @auth
                <a href="{{ route('checkout.index') }}" class="w-full btn-glow text-slate-900 dark:text-white font-bold py-3.5 rounded-xl flex items-center justify-center gap-2">
                    Lanjut ke Checkout →
                </a>
                @else
                <a href="{{ route('login') }}" class="w-full btn-glow text-slate-900 dark:text-white font-bold py-3.5 rounded-xl flex items-center justify-center gap-2">
                    Masuk untuk Checkout →
                </a>
                @endauth

                <a href="{{ route('products.index') }}" class="mt-3 w-full text-center text-blue-400 hover:text-blue-300 text-sm py-2 block transition-colors">
                    ← Lanjut Belanja
                </a>
            </div>
        </div>
    </div>

    @else
    <div class="text-center py-24">
        <div class="text-7xl mb-6">🛒</div>
        <h2 class="text-slate-900 dark:text-white font-semibold text-2xl mb-3">Keranjang Kosong</h2>
        <p class="text-slate-500 dark:text-slate-400 mb-8">Belum ada produk di keranjang Anda. Yuk mulai belanja!</p>
        <a href="{{ route('products.index') }}" class="btn-glow text-slate-900 dark:text-white font-bold px-8 py-3.5 rounded-xl inline-block">
            🛍️ Mulai Belanja
        </a>
    </div>
    @endif
</div>
@endsection
