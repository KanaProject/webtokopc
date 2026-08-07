@extends('layouts.admin')
@php use Illuminate\Support\Facades\Storage; @endphp

@section('admin-content')
<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white font-jakarta">Pengaturan</h2>
        <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Kelola informasi toko dan konten halaman utama website.</p>
    </div>

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" x-data="{ activeTab: 'general' }">
        @csrf

        {{-- Tabs --}}
        <div class="flex gap-2 mb-6 border-b border-slate-200 dark:border-white/10 overflow-x-auto pb-1">
            @foreach([
                'general'      => ['label' => '🏪 Informasi Toko'],
                'hero'         => ['label' => '🏠 Hero'],
                'stats'        => ['label' => '📊 Statistik'],
                'promo_banner' => ['label' => '🎯 Banner Promo'],
                'why_us'       => ['label' => '⭐ Keunggulan'],
            ] as $tab => $info)
            <button type="button"
                    @click="activeTab = '{{ $tab }}'"
                    :class="activeTab === '{{ $tab }}'
                        ? 'border-b-2 border-blue-500 text-blue-500 font-semibold'
                        : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
                    class="px-4 py-2.5 text-sm transition-colors whitespace-nowrap">
                {{ $info['label'] }}
            </button>
            @endforeach
        </div>

        {{-- ===== TAB: GENERAL / TOKO ===== --}}
        <div x-show="activeTab === 'general'">
            <div class="space-y-5">

                {{-- Logo --}}
                <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
                    <h3 class="font-semibold text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-purple-500/20 text-purple-400 flex items-center justify-center text-xs">L</span>
                        Logo Toko
                    </h3>

                    {{-- Preview logo saat ini --}}
                    @if(!empty($settings['store_logo']))
                    <div class="mb-5 flex items-center gap-5">
                        <img src="{{ Storage::url($settings['store_logo']) }}"
                             alt="Logo Toko" class="h-20 w-auto object-contain border border-slate-200 dark:border-white/10 p-2 bg-white/50">
                        <div>
                            <p class="text-sm text-slate-600 dark:text-slate-300 font-medium mb-2">Logo saat ini</p>
                            <form method="POST" action="{{ route('admin.settings.logo.delete') }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Hapus logo ini?')"
                                        class="text-xs text-red-400 hover:text-red-300 border border-red-400/30 hover:border-red-400/60 px-3 py-1.5 rounded-lg transition-colors">
                                    🗑️ Hapus Logo
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="mb-5 flex items-center gap-4">
                        <div class="w-20 h-20 rounded-xl bg-blue-500/20 flex items-center justify-center text-3xl font-bold text-blue-400">
                            {{ strtoupper(substr($settings['store_name'] ?? 'T', 0, 1)) }}
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada logo. Upload logo di bawah.</p>
                    </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Upload Logo Baru</label>
                        <input type="file" name="store_logo" accept="image/*"
                               class="w-full px-4 py-2.5 rounded-xl text-sm file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:bg-blue-500/20 file:text-blue-400 file:font-medium file:cursor-pointer hover:file:bg-blue-500/30 transition-all">
                        <p class="text-xs text-slate-400 mt-1">Format: JPG, PNG, WebP, SVG. Maks 2MB. Rekomendasi: 200×200px atau landscape.</p>
                    </div>
                </div>

                {{-- Info Toko --}}
                <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
                    <h3 class="font-semibold text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-green-500/20 text-green-400 flex items-center justify-center text-xs">I</span>
                        Identitas Toko
                    </h3>
                    <div class="grid gap-5">
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nama Toko</label>
                                <input type="text" name="store_name" value="{{ $settings['store_name'] ?? 'TechnoStore' }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="TechnoStore">
                                <p class="text-xs text-slate-400 mt-1">Muncul di navbar, footer, dan tab browser.</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tagline</label>
                                <input type="text" name="store_tagline" value="{{ $settings['store_tagline'] ?? '' }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="Toko Komputer Terpercaya">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Deskripsi Singkat (di footer)</label>
                            <textarea name="store_description" rows="2"
                                      class="w-full px-4 py-2.5 rounded-xl text-sm resize-none"
                                      placeholder="Toko komputer terpercaya...">{{ $settings['store_description'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Kontak --}}
                <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
                    <h3 class="font-semibold text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-xs">K</span>
                        Informasi Kontak (di footer)
                    </h3>
                    <div class="grid gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">📍 Alamat</label>
                            <input type="text" name="store_address" value="{{ $settings['store_address'] ?? '' }}"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="Jl. Sudirman No.1, Jakarta Pusat">
                        </div>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">📞 Nomor Telepon</label>
                                <input type="text" name="store_phone" value="{{ $settings['store_phone'] ?? '' }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="0812-0000-0001">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">✉️ Email</label>
                                <input type="email" name="store_email" value="{{ $settings['store_email'] ?? '' }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="info@toko.com">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- ===== TAB: HERO ===== --}}
        <div x-show="activeTab === 'hero'">
            <div class="space-y-5">
                <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
                    <h3 class="font-semibold text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-blue-500/20 text-blue-400 flex items-center justify-center text-xs">H</span>
                        Bagian Hero (Banner Utama)
                    </h3>
                    <div class="grid gap-5">

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Teks Badge Atas</label>
                            <input type="text" name="hero_badge" value="{{ $settings['hero_badge'] ?? '' }}"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="Stok Tersedia — Pengiriman Seluruh Indonesia">
                            <p class="text-xs text-slate-400 mt-1">Teks kecil dengan titik hijau di atas judul utama.</p>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Judul Utama (baris 1)</label>
                                <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? '' }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="Toko Komputer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Judul Highlight (baris 2, warna gradien)</label>
                                <input type="text" name="hero_title_highlight" value="{{ $settings['hero_title_highlight'] ?? '' }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="Terpercaya #1">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Subtitle / Deskripsi</label>
                            <textarea name="hero_subtitle" rows="3"
                                      class="w-full px-4 py-2.5 rounded-xl text-sm resize-none"
                                      placeholder="Temukan laptop, PC gaming...">{{ $settings['hero_subtitle'] ?? '' }}</textarea>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tombol Utama (CTA)</label>
                                <input type="text" name="hero_cta_primary" value="{{ $settings['hero_cta_primary'] ?? '' }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="🛍️ Belanja Sekarang">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Tombol Sekunder</label>
                                <input type="text" name="hero_cta_secondary" value="{{ $settings['hero_cta_secondary'] ?? '' }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="Lihat Kategori">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- ===== TAB: STATS ===== --}}
        <div x-show="activeTab === 'stats'">
            <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
                <h3 class="font-semibold text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-xs">S</span>
                    Statistik (3 Kotak di bawah Hero)
                </h3>
                <div class="grid gap-6">
                    @foreach([1, 2, 3] as $i)
                    <div class="p-4 rounded-xl border border-slate-200 dark:border-white/5 bg-slate-50 dark:bg-white/3">
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-3">Statistik {{ $i }}</p>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Nilai (misal: 500+)</label>
                                <input type="text" name="stat_{{ $i }}_value" value="{{ $settings['stat_'.$i.'_value'] ?? '' }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="500+">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Label (misal: Produk)</label>
                                <input type="text" name="stat_{{ $i }}_label" value="{{ $settings['stat_'.$i.'_label'] ?? '' }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="Produk">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ===== TAB: PROMO BANNER ===== --}}
        <div x-show="activeTab === 'promo_banner'">
            <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
                <h3 class="font-semibold text-slate-900 dark:text-white mb-5 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-yellow-500/20 text-yellow-400 flex items-center justify-center text-xs">P</span>
                    Banner Promo (Section Biru Tengah)
                </h3>
                <div class="grid gap-5">

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Teks Badge Kecil</label>
                        <input type="text" name="promo_badge" value="{{ $settings['promo_badge'] ?? '' }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="⚡ Penawaran Spesial">
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Judul (teks biasa)</label>
                            <input type="text" name="promo_title" value="{{ $settings['promo_title'] ?? '' }}"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="Diskon hingga">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Highlight (kuning, misal: 30%)</label>
                            <input type="text" name="promo_highlight" value="{{ $settings['promo_highlight'] ?? '' }}"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="30%">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Keterangan / Subtitle</label>
                        <input type="text" name="promo_subtitle" value="{{ $settings['promo_subtitle'] ?? '' }}"
                               class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="untuk produk pilihan kategori Laptop & PC Gaming">
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Teks Tombol</label>
                            <input type="text" name="promo_cta" value="{{ $settings['promo_cta'] ?? '' }}"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="Cek Sekarang →">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Slug Kategori Tujuan</label>
                            <input type="text" name="promo_link_slug" value="{{ $settings['promo_link_slug'] ?? '' }}"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="laptop">
                            <p class="text-xs text-slate-400 mt-1">Slug kategori yang dituju tombol promo (misal: <code>laptop</code>, <code>pc-desktop</code>).</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ===== TAB: WHY US ===== --}}
        <div x-show="activeTab === 'why_us'">
            <div class="space-y-5">

                <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
                    <h3 class="font-semibold text-slate-900 dark:text-white mb-5">Judul Section "Mengapa Kami"</h3>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Teks biasa</label>
                            <input type="text" name="why_us_title" value="{{ $settings['why_us_title'] ?? '' }}"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="Mengapa">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Teks highlight (gradien)</label>
                            <input type="text" name="why_us_highlight" value="{{ $settings['why_us_highlight'] ?? '' }}"
                                   class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="TechnoStore?">
                        </div>
                    </div>
                </div>

                @foreach(range(1,6) as $i)
                <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
                    <p class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-4">Keunggulan {{ $i }}</p>
                    <div class="grid gap-4">
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Ikon (emoji)</label>
                                <input type="text" name="feature_{{ $i }}_icon" value="{{ $settings['feature_'.$i.'_icon'] ?? '' }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm text-center text-2xl" placeholder="🛡️">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Judul</label>
                                <input type="text" name="feature_{{ $i }}_title" value="{{ $settings['feature_'.$i.'_title'] ?? '' }}"
                                       class="w-full px-4 py-2.5 rounded-xl text-sm" placeholder="Produk Original">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Deskripsi</label>
                            <textarea name="feature_{{ $i }}_desc" rows="2"
                                      class="w-full px-4 py-2.5 rounded-xl text-sm resize-none"
                                      placeholder="Deskripsi keunggulan...">{{ $settings['feature_'.$i.'_desc'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>

        {{-- Submit --}}
        <div class="mt-8 flex items-center justify-end gap-4 sticky bottom-6">
            <div class="glass rounded-2xl px-6 py-4 flex items-center gap-4 border border-slate-200 dark:border-white/10 shadow-xl">
                <a href="{{ route('home') }}" target="_blank"
                   class="text-sm text-slate-500 dark:text-slate-400 hover:text-blue-400 transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Preview Halaman Utama
                </a>
                <button type="submit"
                        class="btn-glow text-white font-semibold px-6 py-2.5 rounded-xl text-sm flex items-center gap-2 transition-all hover:shadow-lg hover:shadow-blue-500/40">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Semua Perubahan
                </button>
            </div>
        </div>

    </form>
</div>
@endsection
