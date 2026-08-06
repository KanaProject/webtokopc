@extends('layouts.admin')
@php $title = 'Dashboard'; @endphp

@section('admin-content')

{{-- Stat Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
    @php
    $statItems = [
        ['label' => 'Total Produk',  'value' => $stats['total_products'],  'icon' => '📦', 'color' => 'blue'],
        ['label' => 'Total Pesanan', 'value' => $stats['total_orders'],    'icon' => '🧾', 'color' => 'purple'],
        ['label' => 'Pelanggan',     'value' => $stats['total_users'],     'icon' => '👥', 'color' => 'cyan'],
        ['label' => 'Menunggu',      'value' => $stats['pending_orders'],  'icon' => '⏳', 'color' => 'yellow'],
        ['label' => 'Stok Menipis',  'value' => $stats['low_stock'],       'icon' => '⚠️', 'color' => 'orange'],
        ['label' => 'Revenue',       'value' => 'Rp ' . number_format($stats['total_revenue'] / 1000000, 1) . 'jt', 'icon' => '💰', 'color' => 'green'],
    ];
    @endphp
    @foreach($statItems as $stat)
    <div class="stat-card">
        <div class="text-2xl mb-2">{{ $stat['icon'] }}</div>
        <div class="text-slate-900 dark:text-white font-bold text-xl">{{ $stat['value'] }}</div>
        <div class="text-slate-500 dark:text-slate-400 text-xs mt-1">{{ $stat['label'] }}</div>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Recent Orders --}}
    <div class="glass rounded-2xl p-5 border border-slate-200 dark:border-white/5">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-slate-900 dark:text-white font-semibold">Pesanan Terbaru</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-blue-400 text-xs hover:text-blue-300">Lihat Semua →</a>
        </div>
        <div class="space-y-3">
            @foreach($recentOrders as $order)
            <div class="flex items-center justify-between py-2.5 border-b border-slate-200 dark:border-white/5 last:border-0 table-row rounded-lg px-1">
                <div>
                    <div class="text-slate-900 dark:text-white text-sm font-medium">{{ $order->order_number }}</div>
                    <div class="text-slate-500 dark:text-slate-400 text-xs">{{ $order->user?->name ?? 'Guest' }} • {{ $order->created_at->diffForHumans() }}</div>
                </div>
                <div class="text-right">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                        {{ in_array($order->status, ['pending', 'confirmed', 'processing']) ? 'bg-yellow-500/20 text-yellow-300' : '' }}
                        {{ $order->status === 'delivered' ? 'bg-green-500/20 text-green-300' : '' }}
                        {{ $order->status === 'shipped' ? 'bg-purple-500/20 text-purple-300' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-red-500/20 text-red-300' : '' }}
                    ">{{ $order->status_label }}</span>
                    <div class="text-blue-400 text-xs font-bold mt-1">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Popular Products --}}
    <div class="glass rounded-2xl p-5 border border-slate-200 dark:border-white/5">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-slate-900 dark:text-white font-semibold">Produk Populer</h2>
            <a href="{{ route('admin.products.index') }}" class="text-blue-400 text-xs hover:text-blue-300">Kelola →</a>
        </div>
        <div class="space-y-3">
            @foreach($popularProducts as $product)
            <div class="flex items-center gap-3 py-2.5 border-b border-slate-200 dark:border-white/5 last:border-0">
                <div class="w-10 h-10 glass rounded-xl flex items-center justify-center bg-white dark:bg-slate-800 overflow-hidden flex-shrink-0">
                    @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                    <span class="text-xl">💻</span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-slate-900 dark:text-white text-sm font-medium truncate">{{ $product->name }}</div>
                    <div class="text-slate-500 dark:text-slate-400 text-xs">{{ $product->views }} views • Stok: {{ $product->stock }}</div>
                </div>
                <div class="text-blue-400 text-sm font-bold flex-shrink-0">Rp {{ number_format($product->price / 1000000, 1) }}jt</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-3">
    <a href="{{ route('admin.products.create') }}" class="btn-glow text-slate-900 dark:text-white text-sm font-semibold py-3 rounded-xl text-center">+ Tambah Produk</a>
    <a href="{{ route('admin.categories.create') }}" class="glass border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-300 text-sm font-medium py-3 rounded-xl text-center hover:border-blue-500/40 transition-all">+ Tambah Kategori</a>
    <a href="{{ route('admin.orders.index') }}?status=pending" class="glass border border-yellow-500/20 text-yellow-300 text-sm font-medium py-3 rounded-xl text-center hover:bg-yellow-500/10 transition-all">⏳ Pesanan Pending</a>
    <a href="{{ route('home') }}" class="glass border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-300 text-sm font-medium py-3 rounded-xl text-center hover:border-blue-500/40 transition-all">🌐 Lihat Toko</a>
</div>

@endsection
