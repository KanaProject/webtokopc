@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-16 text-center">
    <div class="glass rounded-3xl p-10 border border-green-500/20">
        <div class="w-24 h-24 rounded-full bg-green-500/20 border border-green-500/30 flex items-center justify-center text-5xl mx-auto mb-6">✅</div>
        <h1 class="font-jakarta text-3xl font-bold text-slate-900 dark:text-white mb-3">Pesanan Berhasil!</h1>
        <p class="text-slate-500 dark:text-slate-400 mb-6">Terima kasih telah berbelanja di TechnoStore. Pesanan Anda sedang kami proses.</p>

        <div class="glass rounded-2xl p-5 mb-8 text-left">
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div>
                    <span class="text-slate-500 dark:text-slate-400">No. Pesanan</span>
                    <div class="text-blue-400 font-bold">{{ $order->order_number }}</div>
                </div>
                <div>
                    <span class="text-slate-500 dark:text-slate-400">Status</span>
                    <div class="text-yellow-400 font-semibold">Menunggu Konfirmasi</div>
                </div>
                <div>
                    <span class="text-slate-500 dark:text-slate-400">Pembayaran</span>
                    <div class="text-slate-900 dark:text-white font-medium capitalize">{{ $order->payment_method }}</div>
                </div>
                <div>
                    <span class="text-slate-500 dark:text-slate-400">Total</span>
                    <div class="text-slate-900 dark:text-white font-bold">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('orders.show', $order) }}" class="btn-glow text-slate-900 dark:text-white font-bold px-6 py-3 rounded-xl">
                Lihat Detail Pesanan
            </a>
            <a href="{{ route('products.index') }}" class="btn-outline text-blue-400 font-semibold px-6 py-3 rounded-xl border border-blue-500/40 hover:bg-blue-500/10 transition-all">
                Lanjut Belanja
            </a>
        </div>
    </div>
</div>
@endsection
