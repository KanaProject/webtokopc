@extends('layouts.admin')
@php $title = 'Edit Produk'; @endphp

@section('admin-content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.products.index') }}" class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:text-white">← Kembali</a>
    <span class="text-slate-600">/</span>
    <h1 class="text-slate-900 dark:text-white font-jakarta font-bold text-2xl">Edit: {{ $product->name }}</h1>
</div>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    @include('admin.products._form', ['product' => $product])
    <div class="mt-6 flex gap-3">
        <button type="submit" class="btn-glow text-slate-900 dark:text-white font-bold px-8 py-3 rounded-xl">Perbarui Produk</button>
        <a href="{{ route('admin.products.index') }}" class="glass text-slate-500 dark:text-slate-400 font-medium px-6 py-3 rounded-xl border border-slate-300 dark:border-white/10 hover:text-slate-900 dark:text-white">Batal</a>
    </div>
</form>
@endsection
