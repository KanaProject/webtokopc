@extends('layouts.admin')
@php $title = 'Kelola Pesanan'; @endphp

@section('admin-content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <h1 class="text-slate-900 dark:text-white font-jakarta font-bold text-2xl">Kelola Pesanan</h1>
</div>

{{-- Filter --}}
<div class="glass rounded-2xl p-4 border border-slate-200 dark:border-white/5 mb-6 flex gap-2 overflow-x-auto pb-2">
    @php
    $statuses = [
        '' => 'Semua',
        'pending' => 'Pending',
        'confirmed' => 'Dikonfirmasi',
        'processing' => 'Diproses',
        'shipped' => 'Dikirim',
        'delivered' => 'Selesai',
        'cancelled' => 'Dibatalkan'
    ];
    $currentStatus = request('status', '');
    @endphp
    
    @foreach($statuses as $value => $label)
    <a href="{{ route('admin.orders.index', ['status' => $value]) }}" 
       class="whitespace-nowrap px-4 py-2 rounded-xl text-sm font-medium transition-colors border
              {{ $currentStatus === $value 
                 ? 'bg-blue-500/20 text-blue-300 border-blue-500/40' 
                 : 'glass text-slate-500 dark:text-slate-400 border-slate-200 dark:border-white/5 hover:text-slate-900 dark:text-white' }}">
        {{ $label }}
    </a>
    @endforeach
</div>

<div class="glass rounded-2xl border border-slate-200 dark:border-white/5 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="border-b border-slate-200 dark:border-white/5">
            <tr class="text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">
                <th class="px-5 py-4 text-left">No. Pesanan</th>
                <th class="px-5 py-4 text-left hidden sm:table-cell">Pelanggan</th>
                <th class="px-5 py-4 text-left hidden lg:table-cell">Tanggal</th>
                <th class="px-5 py-4 text-center">Status</th>
                <th class="px-5 py-4 text-right">Total</th>
                <th class="px-5 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @foreach($orders as $order)
            <tr class="table-row">
                <td class="px-5 py-4">
                    <div class="text-slate-900 dark:text-white font-medium">{{ $order->order_number }}</div>
                </td>
                <td class="px-5 py-4 hidden sm:table-cell">
                    <div class="text-slate-900 dark:text-white font-medium">{{ $order->user?->name ?? $order->shipping_name }}</div>
                    <div class="text-slate-500 text-xs">{{ $order->shipping_phone }}</div>
                </td>
                <td class="px-5 py-4 text-slate-700 dark:text-slate-300 hidden lg:table-cell">
                    {{ $order->created_at->format('d M Y, H:i') }}
                </td>
                <td class="px-5 py-4 text-center">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                        {{ in_array($order->status, ['pending', 'confirmed', 'processing']) ? 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30' : '' }}
                        {{ $order->status === 'delivered' ? 'bg-green-500/20 text-green-300 border border-green-500/30' : '' }}
                        {{ $order->status === 'shipped' ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-red-500/20 text-red-300 border border-red-500/30' : '' }}
                    ">{{ $order->status_label }}</span>
                </td>
                <td class="px-5 py-4 text-right">
                    <div class="text-blue-400 font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                    <div class="text-slate-500 text-xs">{{ strtoupper($order->payment_method) }}</div>
                </td>
                <td class="px-5 py-4 text-right">
                    <a href="{{ route('admin.orders.show', $order) }}" class="glass text-blue-400 text-xs px-4 py-2 rounded-lg border border-blue-500/20 hover:bg-blue-500/10 transition-all">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($orders->isEmpty())
    <div class="text-center py-16 text-slate-500 dark:text-slate-400">
        <div class="text-5xl mb-4">🧾</div>
        <p>Belum ada pesanan.</p>
    </div>
    @endif
</div>

@if($orders->hasPages())
<div class="mt-6">{{ $orders->links('partials.pagination') }}</div>
@endif
@endsection
