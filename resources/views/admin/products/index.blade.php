@extends('layouts.admin')
@php $title = 'Kelola Produk'; @endphp

@section('admin-content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <h1 class="text-slate-900 dark:text-white font-jakarta font-bold text-2xl">Kelola Produk</h1>
    <a href="{{ route('admin.products.create') }}" class="btn-glow text-slate-900 dark:text-white font-semibold px-5 py-2.5 rounded-xl text-sm inline-flex items-center gap-2">
        + Tambah Produk
    </a>
</div>

{{-- Filter --}}
<div class="glass rounded-2xl p-4 border border-slate-200 dark:border-white/5 mb-6">
    <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
        <input type="text" name="search" placeholder="Cari nama / SKU..." value="{{ request('search') }}"
               class="flex-1 px-4 py-2 text-sm text-slate-900 dark:text-white placeholder-slate-500 focus:outline-none focus:border-blue-500/50">
        <select name="category_id" class="px-3 py-2 text-sm text-slate-900 dark:text-white focus:outline-none">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-glow text-slate-900 dark:text-white text-sm font-semibold px-5 py-2 rounded-xl">Cari</button>
        <a href="{{ route('admin.products.index') }}" class="glass text-slate-500 dark:text-slate-400 text-sm px-4 py-2 rounded-xl border border-slate-300 dark:border-white/10 hover:text-slate-900 dark:text-white text-center">Reset</a>
    </form>
</div>

<div class="glass rounded-2xl border border-slate-200 dark:border-white/5 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="border-b border-slate-200 dark:border-white/5">
            <tr class="text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">
                <th class="px-5 py-4 text-left">Produk</th>
                <th class="px-5 py-4 text-left hidden sm:table-cell">Kategori</th>
                <th class="px-5 py-4 text-right">Harga</th>
                <th class="px-5 py-4 text-center hidden md:table-cell">Stok</th>
                <th class="px-5 py-4 text-center hidden lg:table-cell">Status</th>
                <th class="px-5 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @foreach($products as $product)
            <tr class="table-row">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 glass rounded-xl overflow-hidden flex-shrink-0 flex items-center justify-center bg-white dark:bg-slate-800">
                            @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                            <span>💻</span>
                            @endif
                        </div>
                        <div>
                            <div class="text-slate-900 dark:text-white font-medium line-clamp-1">{{ $product->name }}</div>
                            <div class="text-slate-500 text-xs">{{ $product->brand }} • {{ $product->sku }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4 text-slate-700 dark:text-slate-300 hidden sm:table-cell">{{ $product->category->name }}</td>
                <td class="px-5 py-4 text-right text-blue-400 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="px-5 py-4 text-center hidden md:table-cell">
                    <span class="{{ $product->stock <= 5 ? 'text-orange-400' : 'text-green-400' }} font-medium">{{ $product->stock }}</span>
                </td>
                <td class="px-5 py-4 text-center hidden lg:table-cell">
                    @if($product->is_active)
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-green-500/20 text-green-300">Aktif</span>
                    @else
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-500/20 text-slate-500 dark:text-slate-400">Non-aktif</span>
                    @endif
                    @if($product->is_featured)
                    <span class="text-xs font-semibold px-2 py-1 rounded-full bg-yellow-500/20 text-yellow-300 ml-1">⭐</span>
                    @endif
                </td>
                <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="glass text-blue-400 hover:text-blue-300 text-xs px-3 py-1.5 rounded-lg border border-blue-500/20 hover:bg-blue-500/10 transition-all">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="glass text-red-400 hover:text-red-300 text-xs px-3 py-1.5 rounded-lg border border-red-500/20 hover:bg-red-500/10 transition-all">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($products->isEmpty())
    <div class="text-center py-16 text-slate-500 dark:text-slate-400">
        <div class="text-5xl mb-4">📦</div>
        <p>Belum ada produk.</p>
    </div>
    @endif
</div>

@if($products->hasPages())
<div class="mt-6">{{ $products->links('partials.pagination') }}</div>
@endif

@endsection
