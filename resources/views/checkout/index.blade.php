@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="font-jakarta text-3xl font-bold text-slate-900 dark:text-white mb-8">📦 Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Form --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Shipping Info --}}
                <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
                    <h2 class="text-slate-900 dark:text-white font-semibold text-lg mb-5">📍 Informasi Pengiriman</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Nama Penerima *</label>
                            <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required
                                   class="w-full bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl px-4 py-3 text-slate-900 dark:text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500/50 @error('shipping_name') border-red-500 @enderror">
                            @error('shipping_name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Nomor HP *</label>
                            <input type="text" name="shipping_phone" value="{{ old('shipping_phone', auth()->user()->phone) }}" required
                                   placeholder="08xx-xxxx-xxxx"
                                   class="w-full bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl px-4 py-3 text-slate-900 dark:text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500/50 @error('shipping_phone') border-red-500 @enderror">
                            @error('shipping_phone')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Kota *</label>
                            <input type="text" name="shipping_city" value="{{ old('shipping_city') }}" required
                                   placeholder="Jakarta"
                                   class="w-full bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl px-4 py-3 text-slate-900 dark:text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500/50 @error('shipping_city') border-red-500 @enderror">
                            @error('shipping_city')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Provinsi *</label>
                            <input type="text" name="shipping_province" value="{{ old('shipping_province') }}" required
                                   placeholder="DKI Jakarta"
                                   class="w-full bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl px-4 py-3 text-slate-900 dark:text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500/50 @error('shipping_province') border-red-500 @enderror">
                            @error('shipping_province')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Kode Pos *</label>
                            <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code') }}" required
                                   placeholder="10110"
                                   class="w-full bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl px-4 py-3 text-slate-900 dark:text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500/50 @error('shipping_postal_code') border-red-500 @enderror">
                            @error('shipping_postal_code')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Alamat Lengkap *</label>
                            <textarea name="shipping_address" rows="3" required
                                      placeholder="Nama jalan, no rumah, RT/RW, kelurahan, kecamatan..."
                                      class="w-full bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl px-4 py-3 text-slate-900 dark:text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500/50 @error('shipping_address') border-red-500 @enderror">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                            @error('shipping_address')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Catatan (opsional)</label>
                            <textarea name="notes" rows="2" placeholder="Catatan untuk kurir atau penjual..."
                                      class="w-full bg-slate-100 dark:bg-white/5 border border-slate-300 dark:border-white/10 rounded-xl px-4 py-3 text-slate-900 dark:text-white text-sm placeholder-slate-500 focus:outline-none focus:border-blue-500/50">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Payment --}}
                <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
                    <h2 class="text-slate-900 dark:text-white font-semibold text-lg mb-5">💳 Metode Pembayaran</h2>
                    <div class="space-y-3">
                        @php
                        $payments = [
                            'transfer' => ['label' => 'Transfer Bank', 'desc' => 'BCA, Mandiri, BNI, BRI', 'icon' => '🏦'],
                            'ewallet'  => ['label' => 'E-Wallet', 'desc' => 'GoPay, OVO, DANA, ShopeePay', 'icon' => '📱'],
                            'cod'      => ['label' => 'Bayar di Tempat (COD)', 'desc' => 'Bayar saat barang tiba', 'icon' => '💵'],
                        ];
                        @endphp
                        @foreach($payments as $key => $pay)
                        <label class="flex items-center gap-4 glass rounded-xl p-4 cursor-pointer border border-slate-200 dark:border-white/5 hover:border-blue-500/40 transition-all has-[:checked]:border-blue-500/60 has-[:checked]:bg-blue-500/10">
                            <input type="radio" name="payment_method" value="{{ $key }}" class="accent-blue-500"
                                   {{ old('payment_method', 'transfer') === $key ? 'checked' : '' }}>
                            <span class="text-2xl">{{ $pay['icon'] }}</span>
                            <div>
                                <div class="text-slate-900 dark:text-white font-medium text-sm">{{ $pay['label'] }}</div>
                                <div class="text-slate-500 text-xs">{{ $pay['desc'] }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="lg:col-span-1">
                <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5 sticky top-24">
                    <h2 class="text-slate-900 dark:text-white font-semibold text-lg mb-5">Ringkasan</h2>

                    <div class="space-y-3 mb-5">
                        @foreach($cart as $item)
                        <div class="flex gap-3">
                            <div class="w-12 h-12 glass rounded-lg overflow-hidden flex-shrink-0 flex items-center justify-center bg-white dark:bg-slate-800">
                                @if($item['image'])
                                <img src="{{ Storage::url($item['image']) }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                                @else
                                <span>💻</span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-slate-700 dark:text-slate-300 text-xs line-clamp-1">{{ $item['name'] }}</div>
                                <div class="text-slate-500 dark:text-slate-400 text-xs">× {{ $item['quantity'] }}</div>
                                <div class="text-blue-400 text-xs font-semibold">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <hr class="border-slate-300 dark:border-white/10 mb-4">

                    <div class="space-y-2 mb-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500 dark:text-slate-400">Subtotal</span>
                            <span class="text-slate-900 dark:text-white">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500 dark:text-slate-400">Ongkir</span>
                            <span class="text-slate-900 dark:text-white">Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <hr class="border-slate-300 dark:border-white/10 mb-4">

                    <div class="flex justify-between mb-6">
                        <span class="text-slate-900 dark:text-white font-semibold">Total</span>
                        <span class="text-blue-400 font-bold text-xl">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="w-full btn-glow text-slate-900 dark:text-white font-bold py-4 rounded-xl flex items-center justify-center gap-2 text-base">
                        ✅ Buat Pesanan
                    </button>

                    <a href="{{ route('cart.index') }}" class="mt-3 w-full text-center text-slate-500 dark:text-slate-400 hover:text-blue-400 text-sm py-2 block transition-colors">
                        ← Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
