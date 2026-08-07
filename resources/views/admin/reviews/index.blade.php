@extends('layouts.admin')
@php $title = 'Kelola Ulasan Produk'; @endphp

@section('admin-content')
<div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4">
    <h1 class="text-slate-900 dark:text-white font-jakarta font-bold text-2xl">Ulasan Produk</h1>
    
    <form action="{{ route('admin.reviews.index') }}" method="GET" class="flex items-center gap-2">
        <select name="rating" onchange="this.form.submit()" class="bg-white/50 dark:bg-[#0A101F]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-2 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
            <option value="">Semua Bintang</option>
            <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ 5 Bintang</option>
            <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ 4 Bintang</option>
            <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ 3 Bintang</option>
            <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>⭐⭐ 2 Bintang</option>
            <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>⭐ 1 Bintang</option>
        </select>
    </form>
</div>

<div class="glass rounded-2xl border border-slate-200 dark:border-white/5 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="border-b border-slate-200 dark:border-white/5">
            <tr class="text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">
                <th class="px-5 py-4 text-left">Pelanggan</th>
                <th class="px-5 py-4 text-left">Produk</th>
                <th class="px-5 py-4 text-left">Komentar</th>
                <th class="px-5 py-4 text-center">Status</th>
                <th class="px-5 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($reviews as $review)
            <tr class="table-row">
                <td class="px-5 py-4">
                    <div class="text-slate-900 dark:text-white font-medium">{{ $review->user->name }}</div>
                    <div class="text-slate-500 text-xs">{{ $review->created_at->format('d M Y') }}</div>
                </td>
                <td class="px-5 py-4">
                    <div class="text-slate-900 dark:text-white font-medium">{{ Str::limit($review->product->name, 30) }}</div>
                    <div class="text-yellow-400 text-sm">{!! str_repeat('★', $review->rating) !!}</div>
                </td>
                <td class="px-5 py-4 text-slate-700 dark:text-slate-300 w-1/3">
                    {{ $review->comment }}
                </td>
                <td class="px-5 py-4 text-center">
                    @if($review->is_approved)
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-green-500/20 text-green-300">Tampil</span>
                    @else
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-red-500/20 text-red-400">Disembunyikan</span>
                    @endif
                </td>
                <td class="px-5 py-4 text-right">
                    <form action="{{ route('admin.reviews.toggle', $review) }}" method="POST">
                        @csrf @method('PATCH')
                        @if($review->is_approved)
                        <button type="submit" class="glass text-red-400 text-xs px-3 py-1.5 rounded-lg border border-red-500/20 hover:bg-red-500/10 transition-all">Sembunyikan</button>
                        @else
                        <button type="submit" class="glass text-green-400 text-xs px-3 py-1.5 rounded-lg border border-green-500/20 hover:bg-green-500/10 transition-all">Tampilkan</button>
                        @endif
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-8 text-center text-slate-500">Belum ada ulasan produk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($reviews->hasPages())
    <div class="px-5 py-4 border-t border-slate-200 dark:border-white/5">
        {{ $reviews->links() }}
    </div>
    @endif
</div>
@endsection
