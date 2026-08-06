@extends('layouts.admin')
@php $title = 'Edit Kategori'; @endphp

@section('admin-content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.categories.index') }}" class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white">← Kembali</a>
    <span class="text-slate-600">/</span>
    <h1 class="text-slate-900 dark:text-white font-jakarta font-bold text-2xl">Edit: {{ $category->name }}</h1>
</div>

<form action="{{ route('admin.categories.update', $category) }}" method="POST">
    @csrf @method('PUT')
    <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5 max-w-2xl">
        <div class="space-y-4">
            <div>
                <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Nama Kategori *</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                       class="w-full px-4 py-3 text-sm placeholder-slate-500">
                @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            
            <div>
                <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Ikon (Emoji) *</label>
                <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" required
                       class="w-full px-4 py-3 text-sm placeholder-slate-500">
                @error('icon')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-3 text-sm placeholder-slate-500">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Urutan (Sort Order)</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" min="0"
                           class="w-full px-4 py-3 text-sm">
                </div>
                <div>
                    <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Status</label>
                    <div class="pt-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="accent-blue-500 w-4 h-4" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                            <span class="text-slate-700 dark:text-slate-300 text-sm">Aktif</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-6 pt-6 border-t border-slate-200 dark:border-white/5 flex gap-3">
            <button type="submit" class="btn-glow text-slate-900 dark:text-white font-bold px-8 py-3 rounded-xl">Perbarui Kategori</button>
            <a href="{{ route('admin.categories.index') }}" class="glass text-slate-500 dark:text-slate-400 font-medium px-6 py-3 rounded-xl border border-slate-300 dark:border-white/10 hover:text-slate-900 dark:text-white">Batal</a>
        </div>
    </div>
</form>
@endsection
