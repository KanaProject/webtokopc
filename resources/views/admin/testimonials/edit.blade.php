@extends('layouts.admin')
@php $title = 'Edit Testimoni'; @endphp

@section('admin-content')
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.testimonials.index') }}" class="text-slate-400 hover:text-white transition-colors">
        ← Kembali
    </a>
    <h1 class="text-slate-900 dark:text-white font-jakarta font-bold text-2xl">Edit Testimoni</h1>
</div>

<div class="glass rounded-2xl border border-slate-200 dark:border-white/5 p-6 md:p-8 max-w-3xl">
    <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            
            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama Pelanggan <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $testimonial->name) }}" required
                       class="w-full bg-white/50 dark:bg-[#0A101F]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Role/Location --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Profesi / Lokasi</label>
                <input type="text" name="role_or_location" value="{{ old('role_or_location', $testimonial->role_or_location) }}"
                       class="w-full bg-white/50 dark:bg-[#0A101F]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
            </div>

            {{-- Komentar --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Komentar / Ulasan <span class="text-red-500">*</span></label>
                <textarea name="content" rows="4" required
                          class="w-full bg-white/50 dark:bg-[#0A101F]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">{{ old('content', $testimonial->content) }}</textarea>
            </div>

            {{-- Rating & Urutan --}}
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Bintang (1-5) <span class="text-red-500">*</span></label>
                    <input type="number" name="rating" value="{{ old('rating', $testimonial->rating) }}" min="1" max="5" required
                           class="w-full bg-white/50 dark:bg-[#0A101F]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Urutan Tampil <span class="text-red-500">*</span></label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order) }}" required
                           class="w-full bg-white/50 dark:bg-[#0A101F]/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-2.5 text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                </div>
            </div>

            {{-- Status --}}
            <div class="flex items-center gap-3 pt-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}
                       class="w-5 h-5 rounded border-slate-200 dark:border-white/10 bg-white/50 dark:bg-[#0A101F]/50 text-blue-500 focus:ring-blue-500 focus:ring-offset-slate-900">
                <label for="is_active" class="text-slate-700 dark:text-slate-300 text-sm font-medium">Tampilkan di Homepage</label>
            </div>

            {{-- Submit --}}
            <div class="pt-6">
                <button type="submit" class="w-full btn-glow text-slate-900 dark:text-white font-semibold rounded-xl px-6 py-3">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
