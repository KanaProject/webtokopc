<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Main Info --}}
    <div class="lg:col-span-2 space-y-5">
        <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
            <h2 class="text-slate-900 dark:text-white font-semibold mb-5">Informasi Produk</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Nama Produk *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required
                           class="w-full px-4 py-3 text-sm placeholder-slate-500"
                           placeholder="Contoh: ASUS ROG Zephyrus G14">
                    @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Kategori *</label>
                    <select name="category_id" required class="w-full px-4 py-3 text-sm">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Brand</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand ?? '') }}"
                           class="w-full px-4 py-3 text-sm placeholder-slate-500" placeholder="ASUS, Apple, dll">
                </div>

                <div>
                    <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}"
                           class="w-full px-4 py-3 text-sm placeholder-slate-500" placeholder="PROD-001">
                </div>

                <div>
                    <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Harga *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}" required min="0"
                           class="w-full px-4 py-3 text-sm placeholder-slate-500" placeholder="15000000">
                    @error('price')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Harga Asli (sebelum diskon)</label>
                    <input type="number" name="original_price" value="{{ old('original_price', $product->original_price ?? '') }}" min="0"
                           class="w-full px-4 py-3 text-sm placeholder-slate-500" placeholder="20000000">
                </div>

                <div>
                    <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Stok *</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required min="0"
                           class="w-full px-4 py-3 text-sm">
                    @error('stock')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Deskripsi Singkat *</label>
                    <textarea name="description" rows="3" required
                              class="w-full px-4 py-3 text-sm placeholder-slate-500"
                              placeholder="Deskripsi singkat produk...">{{ old('description', $product->description ?? '') }}</textarea>
                    @error('description')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-slate-700 dark:text-slate-300 text-sm font-medium mb-1.5">Deskripsi Panjang</label>
                    <textarea name="long_description" rows="5"
                              class="w-full px-4 py-3 text-sm placeholder-slate-500"
                              placeholder="Deskripsi lengkap produk...">{{ old('long_description', $product->long_description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Specifications --}}
        <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5" x-data="{ specs: {{ json_encode(isset($product) && $product->specs ? collect($product->specs)->map(fn($v, $k) => ['key' => $k, 'value' => $v])->values()->toArray() : [['key'=>'', 'value'=>'']]) }} }">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-slate-900 dark:text-white font-semibold">Spesifikasi</h2>
                <button type="button" @click="specs.push({key:'', value:''})" class="text-blue-400 hover:text-blue-300 text-sm">+ Tambah</button>
            </div>

            <div class="space-y-3">
                <template x-for="(spec, i) in specs" :key="i">
                    <div class="flex gap-3">
                        <input type="text" :name="'specs[key][' + i + ']'" x-model="spec.key"
                               class="flex-1 px-3 py-2 text-sm placeholder-slate-500" placeholder="Contoh: RAM">
                        <input type="text" :name="'specs[value][' + i + ']'" x-model="spec.value"
                               class="flex-1 px-3 py-2 text-sm placeholder-slate-500" placeholder="Contoh: 16GB DDR5">
                        <button type="button" @click="specs.splice(i,1)" class="text-red-400 hover:text-red-300 px-2">✕</button>
                    </div>
                </template>
            </div>
        </div>
    </div>

    {{-- Side Panel --}}
    <div class="space-y-5">
        {{-- Image --}}
        <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
            <h2 class="text-slate-900 dark:text-white font-semibold mb-4">Gambar Produk</h2>
            @if(isset($product) && $product->image)
            <img src="{{ Storage::url($product->image) }}" alt="Current" class="w-full rounded-xl mb-3 object-cover aspect-square">
            @endif
            <input type="file" name="image" accept="image/*" id="image-upload"
                   class="w-full px-3 py-2 text-sm text-slate-700 dark:text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-500/20 file:text-blue-300 hover:file:bg-blue-500/30 cursor-pointer">
            <p class="text-slate-500 text-xs mt-2">Max 2MB. Format: JPG, PNG, WebP</p>
        </div>

        {{-- Status --}}
        <div class="glass rounded-2xl p-6 border border-slate-200 dark:border-white/5">
            <h2 class="text-slate-900 dark:text-white font-semibold mb-4">Status</h2>
            <div class="space-y-3">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" class="accent-blue-500 w-4 h-4"
                           {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                    <span class="text-slate-700 dark:text-slate-300 text-sm">Produk Aktif (tampil di toko)</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" class="accent-yellow-400 w-4 h-4"
                           {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                    <span class="text-slate-700 dark:text-slate-300 text-sm">⭐ Produk Unggulan (tampil di homepage)</span>
                </label>
            </div>
        </div>
    </div>
</div>
