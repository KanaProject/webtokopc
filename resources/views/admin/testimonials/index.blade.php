@extends('layouts.admin')
@php $title = 'Kelola Testimoni Homepage'; @endphp

@section('admin-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-slate-900 dark:text-white font-jakarta font-bold text-2xl">Kelola Testimoni</h1>
    <a href="{{ route('admin.testimonials.create') }}" class="btn-glow text-slate-900 dark:text-white font-semibold px-5 py-2.5 rounded-xl text-sm">+ Tambah Testimoni</a>
</div>

<div class="glass rounded-2xl border border-slate-200 dark:border-white/5 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="border-b border-slate-200 dark:border-white/5">
            <tr class="text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider">
                <th class="px-5 py-4 text-left">Pelanggan</th>
                <th class="px-5 py-4 text-left">Komentar</th>
                <th class="px-5 py-4 text-center">Bintang</th>
                <th class="px-5 py-4 text-center">Urutan</th>
                <th class="px-5 py-4 text-center">Status</th>
                <th class="px-5 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($testimonials as $testimonial)
            <tr class="table-row">
                <td class="px-5 py-4">
                    <div class="text-slate-900 dark:text-white font-medium">{{ $testimonial->name }}</div>
                    <div class="text-slate-500 text-xs">{{ $testimonial->role_or_location }}</div>
                </td>
                <td class="px-5 py-4 text-slate-700 dark:text-slate-300 w-1/3">
                    {{ Str::limit($testimonial->content, 50) }}
                </td>
                <td class="px-5 py-4 text-center text-yellow-400 text-lg">
                    {!! str_repeat('★', $testimonial->rating) !!}
                </td>
                <td class="px-5 py-4 text-center text-slate-700 dark:text-slate-300">{{ $testimonial->sort_order }}</td>
                <td class="px-5 py-4 text-center">
                    @if($testimonial->is_active)
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-green-500/20 text-green-300">Tampil</span>
                    @else
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-500/20 text-slate-500 dark:text-slate-400">Sembunyi</span>
                    @endif
                </td>
                <td class="px-5 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="glass text-blue-400 text-xs px-3 py-1.5 rounded-lg border border-blue-500/20 hover:bg-blue-500/10 transition-all">Edit</a>
                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" onsubmit="return confirm('Hapus testimoni ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="glass text-red-400 text-xs px-3 py-1.5 rounded-lg border border-red-500/20 hover:bg-red-500/10 transition-all">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-5 py-8 text-center text-slate-500">Belum ada testimoni.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
