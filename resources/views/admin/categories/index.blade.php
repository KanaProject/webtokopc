@extends('layouts.admin')
@php $title = 'Kelola Kategori'; @endphp

@section('admin-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-slate-900 dark:text-white font-jakarta font-bold text-2xl">Kelola Kategori</h1>
    <a href="{{ route('admin.categories.create') }}" class="btn-glow text-slate-900 dark:text-white font-semibold px-5 py-2.5 rounded-xl text-sm">+ Tambah Kategori</a>
</div>

<div class="glass rounded-2xl border border-slate-200 dark:border-white/5 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="border-b border-slate-200 dark:border-white/5">
            <tr class="text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">
                <th class="px-5 py-4 text-left">Kategori</th>
                <th class="px-5 py-4 text-center">Produk</th>
                <th class="px-5 py-4 text-center">Urutan</th>
                <th class="px-5 py-4 text-center">Status</th>
                <th class="px-5 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @foreach($categories as $category)
            <tr class="table-row">
                <td class="px-5 py-4">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">{{ $category->icon }}</span>
                        <div>
                            <div class="text-slate-900 dark:text-white font-medium">{{ $category->name }}</div>
                            <div class="text-slate-500 text-xs">{{ $category->slug }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-4 text-center">
                    <a href="{{ route('admin.products.index') }}?category_id={{ $category->id }}" class="text-blue-400 hover:underline">{{ $category->products_count }}</a>
                </td>
                <td class="px-5 py-4 text-center text-slate-700 dark:text-slate-300">{{ $category->sort_order }}</td>
                <td class="px-5 py-4 text-center">
                    @if($category->is_active)
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-green-500/20 text-green-300">Aktif</span>
                    @else
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-500/20 text-slate-500 dark:text-slate-400">Non-aktif</span>
                    @endif
                </td>
                <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="glass text-blue-400 text-xs px-3 py-1.5 rounded-lg border border-blue-500/20 hover:bg-blue-500/10 transition-all">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="glass text-red-400 text-xs px-3 py-1.5 rounded-lg border border-red-500/20 hover:bg-red-500/10 transition-all">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
