@extends('layouts.app')

@section('content')
<div class="w-full xl:w-[90%] 2xl:w-[85%] max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-0 py-10">
    <a href="{{ route('orders.index') }}" class="text-blue-400 hover:text-blue-300 text-sm mb-6 inline-flex items-center gap-1">
        ← Kembali ke Pesanan
    </a>

    <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
            <div>
                <h1 class="font-jakarta text-2xl font-bold text-slate-900 dark:text-white">{{ $order->order_number }}</h1>
                <div class="text-slate-500 dark:text-slate-400 text-sm mt-1">{{ $order->created_at->format('d F Y, H:i') }}</div>
            </div>
            <span class="text-sm font-semibold px-4 py-2 rounded-full
                {{ $order->status === 'delivered' ? 'bg-green-100 dark:bg-green-500/20 text-green-700 dark:text-green-300 border border-green-200 dark:border-green-500/30' : '' }}
                {{ $order->status === 'cancelled' ? 'bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-500/30' : '' }}
                {{ $order->status === 'shipped' ? 'bg-purple-100 dark:bg-purple-500/20 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-500/30' : '' }}
                {{ in_array($order->status, ['pending', 'confirmed', 'processing']) ? 'bg-yellow-100 dark:bg-yellow-500/20 text-yellow-700 dark:text-yellow-300 border border-yellow-200 dark:border-yellow-500/30' : '' }}
            ">{{ $order->status_label }}</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-sm">
            <div>
                <span class="text-slate-500 dark:text-slate-400 block mb-1">Pembayaran</span>
                <span class="text-slate-900 dark:text-white font-medium capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
            </div>
            <div>
                <span class="text-slate-500 dark:text-slate-400 block mb-1">Status Bayar</span>
                <span class="text-slate-900 dark:text-white font-medium capitalize">{{ $order->payment_status }}</span>
            </div>
            <div>
                <span class="text-slate-500 dark:text-slate-400 block mb-1">Ongkir</span>
                <span class="text-slate-900 dark:text-white font-medium">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Items --}}
    <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5 mb-6">
        <h2 class="text-slate-900 dark:text-white font-semibold mb-5">🛍️ Item Pesanan</h2>
        <div class="space-y-4">
            @foreach($order->items as $item)
            <div x-data="{ showReviewForm: false }" class="py-3 border-b border-slate-200 dark:border-white/5 last:border-0">
                <div class="flex gap-4">
                    <div class="w-14 h-14 glass rounded-xl flex items-center justify-center flex-shrink-0 bg-white dark:bg-slate-800 overflow-hidden">
                        @if($item->product_image)
                        <img src="{{ Storage::url($item->product_image) }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                        @else
                        <span>💻</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="text-slate-900 dark:text-white text-sm font-medium">{{ $item->product_name }}</div>
                        <div class="text-slate-500 dark:text-slate-400 text-xs mt-1">Rp {{ number_format($item->price, 0, ',', '.') }} × {{ $item->quantity }}</div>
                        
                        @if($order->status === 'completed')
                            @php
                                $hasReviewed = \App\Models\Review::where('user_id', auth()->id())
                                                ->where('order_id', $order->id)
                                                ->where('product_id', $item->product_id)
                                                ->exists();
                            @endphp
                            @if(!$hasReviewed)
                            <div class="mt-2">
                                <button @click="showReviewForm = !showReviewForm" class="text-xs text-blue-500 hover:text-blue-400 font-semibold flex items-center gap-1">
                                    <span x-show="!showReviewForm">⭐ Beri Ulasan</span>
                                    <span x-show="showReviewForm" x-cloak>Tutup Form</span>
                                </button>
                            </div>
                            @else
                            <div class="mt-2 text-xs text-green-500 font-semibold flex items-center gap-1">
                                ✅ Sudah diulas
                            </div>
                            @endif
                        @endif
                    </div>
                    <div class="text-blue-600 dark:text-blue-400 font-semibold text-sm">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</div>
                </div>

                {{-- Review Form --}}
                @if($order->status === 'completed' && !isset($hasReviewed) || ($order->status === 'completed' && isset($hasReviewed) && !$hasReviewed))
                <div x-show="showReviewForm" x-collapse x-cloak class="mt-4 pt-4 border-t border-dashed border-slate-200 dark:border-white/10">
                    <form action="{{ route('orders.reviews.store', $order) }}" method="POST" class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-xl">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                        
                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2">Beri Bintang (1-5)</label>
                            <div class="flex items-center gap-2 text-2xl" x-data="{ rating: 5, hoverRating: 0 }">
                                <input type="hidden" name="rating" x-model="rating">
                                <template x-for="i in 5">
                                    <button type="button" 
                                            @click="rating = i" 
                                            @mouseenter="hoverRating = i" 
                                            @mouseleave="hoverRating = 0"
                                            class="focus:outline-none transition-colors"
                                            :class="(hoverRating >= i || (hoverRating == 0 && rating >= i)) ? 'text-yellow-400' : 'text-slate-300 dark:text-slate-600'">
                                        ★
                                    </button>
                                </template>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-2">Tulis Pengalaman Anda</label>
                            <textarea name="comment" rows="3" required placeholder="Bagaimana kualitas barang ini?"
                                      class="w-full bg-white dark:bg-[#0A101F] border border-slate-200 dark:border-white/10 rounded-xl px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-500"></textarea>
                        </div>

                        <button type="submit" class="btn-glow w-full text-slate-900 dark:text-white font-semibold text-sm py-2 rounded-xl">
                            Kirim Ulasan
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @endforeach

            <div class="flex justify-between pt-3">
                <span class="text-slate-900 dark:text-white font-bold">Total Pesanan</span>
                <span class="text-blue-600 dark:text-blue-400 font-bold text-lg">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Shipping address --}}
    <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
        <h2 class="text-slate-900 dark:text-white font-semibold mb-4">📍 Alamat Pengiriman</h2>
        <div class="text-slate-700 dark:text-slate-300 text-sm space-y-1">
            <p class="font-semibold text-slate-900 dark:text-white">{{ $order->shipping_name }}</p>
            <p>{{ $order->shipping_phone }}</p>
            <p>{{ $order->shipping_address }}</p>
            <p>{{ $order->shipping_city }}, {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</p>
        </div>
        @if($order->notes)
        <div class="mt-4 pt-4 border-t border-slate-200 dark:border-white/5">
            <span class="text-slate-500 dark:text-slate-400 text-xs">Catatan: </span>
            <span class="text-slate-700 dark:text-slate-300 text-sm">{{ $order->notes }}</span>
        </div>
        @endif
    </div>
</div>
@endsection
