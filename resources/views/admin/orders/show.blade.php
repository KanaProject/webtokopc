@extends('layouts.admin')
@php $title = 'Detail Pesanan'; @endphp

@section('admin-content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white">← Kembali</a>
    <span class="text-slate-600">/</span>
    <h1 class="text-slate-900 dark:text-white font-jakarta font-bold text-2xl">Pesanan #{{ $order->order_number }}</h1>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Detail & Items --}}
    <div class="lg:col-span-2 space-y-6">
        
        {{-- Status Update Form --}}
        <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
            <h2 class="text-slate-900 dark:text-white font-semibold mb-4">Update Status Pesanan</h2>
            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                @csrf @method('PATCH')
                <select name="status" class="flex-1 px-4 py-3 text-sm">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending (Menunggu Pembayaran)</option>
                    <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi (Pembayaran Diterima)</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Diproses (Sedang Disiapkan)</option>
                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Dikirim (Dalam Perjalanan)</option>
                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Selesai (Diterima Pelanggan)</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <button type="submit" class="btn-glow text-slate-900 dark:text-white font-bold px-6 py-3 rounded-xl">Update Status</button>
            </form>
        </div>

        {{-- Items --}}
        <div class="glass rounded-2xl border border-slate-200 dark:border-white/5 overflow-hidden">
            <div class="p-5 border-b border-slate-200 dark:border-white/5">
                <h2 class="text-slate-900 dark:text-white font-semibold">Daftar Produk</h2>
            </div>
            <table class="w-full text-sm">
                <thead class="border-b border-slate-200 dark:border-white/5 bg-slate-100 dark:bg-white/5">
                    <tr class="text-slate-500 dark:text-slate-400 text-xs uppercase">
                        <th class="px-5 py-3 text-left">Produk</th>
                        <th class="px-5 py-3 text-center">Qty</th>
                        <th class="px-5 py-3 text-right">Harga</th>
                        <th class="px-5 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach($order->items as $item)
                    <tr>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 glass rounded-lg overflow-hidden flex items-center justify-center bg-white dark:bg-slate-800 flex-shrink-0">
                                    @if($item->product_image)
                                    <img src="{{ Storage::url($item->product_image) }}" class="w-full h-full object-cover">
                                    @else
                                    <span>💻</span>
                                    @endif
                                </div>
                                <div class="text-slate-900 dark:text-white font-medium">{{ $item->product_name }}</div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-center text-slate-700 dark:text-slate-300">{{ $item->quantity }}</td>
                        <td class="px-5 py-4 text-right text-slate-700 dark:text-slate-300">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="px-5 py-4 text-right text-blue-400 font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-5 bg-slate-100 dark:bg-white/5 space-y-2">
                <div class="flex justify-end text-sm">
                    <span class="text-slate-500 dark:text-slate-400 w-32 text-right pr-4">Subtotal</span>
                    <span class="text-slate-900 dark:text-white w-32 text-right">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-end text-sm">
                    <span class="text-slate-500 dark:text-slate-400 w-32 text-right pr-4">Ongkos Kirim</span>
                    <span class="text-slate-900 dark:text-white w-32 text-right">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-end text-base pt-2 font-bold mt-2 border-t border-slate-200 dark:border-white/5">
                    <span class="text-slate-900 dark:text-white w-32 text-right pr-4">Total</span>
                    <span class="text-blue-400 w-32 text-right">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar Info --}}
    <div class="space-y-6">
        <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
            <h2 class="text-slate-900 dark:text-white font-semibold mb-4">Informasi Pelanggan</h2>
            <div class="space-y-4 text-sm">
                <div>
                    <div class="text-slate-500 dark:text-slate-400 mb-1">Nama Pemesan</div>
                    <div class="text-slate-900 dark:text-white font-medium">{{ $order->user?->name ?? 'Guest' }}</div>
                </div>
                <div>
                    <div class="text-slate-500 dark:text-slate-400 mb-1">Email</div>
                    <div class="text-slate-900 dark:text-white">{{ $order->user?->email ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-slate-500 dark:text-slate-400 mb-1">Telepon/WhatsApp</div>
                    <div class="text-slate-900 dark:text-white">{{ $order->shipping_phone }}</div>
                </div>
            </div>
        </div>

        <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
            <h2 class="text-slate-900 dark:text-white font-semibold mb-4">Pengiriman</h2>
            <div class="space-y-3 text-sm text-slate-700 dark:text-slate-300">
                <p class="font-medium text-slate-900 dark:text-white">{{ $order->shipping_name }}</p>
                <p>{{ $order->shipping_address }}</p>
                <p>{{ $order->shipping_city }}, {{ $order->shipping_province }}</p>
                <p>Kode Pos: {{ $order->shipping_postal_code }}</p>
            </div>
            
            @if($order->notes)
            <div class="mt-4 pt-4 border-t border-slate-200 dark:border-white/5">
                <div class="text-slate-500 dark:text-slate-400 text-xs mb-1">Catatan Pembeli:</div>
                <div class="text-slate-700 dark:text-slate-300 text-sm bg-slate-100 dark:bg-white/5 p-3 rounded-lg">{{ $order->notes }}</div>
            </div>
            @endif
        </div>
        
        <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
            <h2 class="text-slate-900 dark:text-white font-semibold mb-4">Pembayaran</h2>
            <div class="space-y-4 text-sm">
                <div>
                    <div class="text-slate-500 dark:text-slate-400 mb-1">Metode</div>
                    <div class="text-slate-900 dark:text-white font-medium capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</div>
                </div>
                <div>
                    <div class="text-slate-500 dark:text-slate-400 mb-1">Status Pembayaran</div>
                    <div class="text-slate-900 dark:text-white font-medium capitalize">{{ $order->payment_status }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
