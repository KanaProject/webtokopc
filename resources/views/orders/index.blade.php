@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="font-jakarta text-3xl font-bold text-slate-900 dark:text-white mb-8">📦 Pesanan Saya</h1>

    @if($orders->count() > 0)
    <div class="space-y-4">
        @foreach($orders as $order)
        <div class="glass rounded-2xl p-5 border border-slate-200 dark:border-white/5 hover:border-blue-500/20 transition-all">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <span class="text-slate-900 dark:text-white font-semibold">{{ $order->order_number }}</span>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                            {{ $order->status === 'delivered' ? 'bg-green-500/20 text-green-300 border border-green-500/30' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-500/20 text-red-300 border border-red-500/30' : '' }}
                            {{ $order->status === 'shipped' ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : '' }}
                            {{ in_array($order->status, ['pending', 'confirmed', 'processing']) ? 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30' : '' }}
                        ">{{ $order->status_label }}</span>
                    </div>
                    <div class="text-slate-500 dark:text-slate-400 text-sm">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    <div class="text-slate-500 dark:text-slate-400 text-sm mt-1">{{ $order->items->count() }} produk</div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <div class="text-slate-500 dark:text-slate-400 text-xs">Total</div>
                        <div class="text-blue-400 font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                    </div>
                    <a href="{{ route('orders.show', $order) }}" class="btn-glow text-slate-900 dark:text-white text-sm font-semibold px-4 py-2 rounded-xl">
                        Detail →
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-8">{{ $orders->links('partials.pagination') }}</div>

    @else
    <div class="text-center py-24">
        <div class="text-7xl mb-6">📭</div>
        <h2 class="text-slate-900 dark:text-white font-semibold text-2xl mb-3">Belum Ada Pesanan</h2>
        <p class="text-slate-500 dark:text-slate-400 mb-8">Anda belum pernah melakukan pembelian.</p>
        <a href="{{ route('products.index') }}" class="btn-glow text-slate-900 dark:text-white font-bold px-8 py-3.5 rounded-xl inline-block">Mulai Belanja</a>
    </div>
    @endif
</div>
@endsection
