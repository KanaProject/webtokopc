<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // === HERO ===
            ['key' => 'hero_badge',           'value' => 'Stok Tersedia — Pengiriman Seluruh Indonesia', 'group' => 'hero'],
            ['key' => 'hero_title',           'value' => 'Toko Komputer',                               'group' => 'hero'],
            ['key' => 'hero_title_highlight', 'value' => 'Terpercaya #1',                               'group' => 'hero'],
            ['key' => 'hero_subtitle',        'value' => 'Temukan laptop, PC gaming, monitor, dan aksesoris komputer terbaik dengan harga kompetitif. Produk original bergaransi resmi.', 'group' => 'hero'],
            ['key' => 'hero_cta_primary',     'value' => '🛍️ Belanja Sekarang',                       'group' => 'hero'],
            ['key' => 'hero_cta_secondary',   'value' => 'Lihat Kategori',                              'group' => 'hero'],

            // === STATS ===
            ['key' => 'stat_1_value', 'value' => '500+', 'group' => 'stats'],
            ['key' => 'stat_1_label', 'value' => 'Produk', 'group' => 'stats'],
            ['key' => 'stat_2_value', 'value' => '10K+', 'group' => 'stats'],
            ['key' => 'stat_2_label', 'value' => 'Pelanggan', 'group' => 'stats'],
            ['key' => 'stat_3_value', 'value' => '4.9★', 'group' => 'stats'],
            ['key' => 'stat_3_label', 'value' => 'Rating', 'group' => 'stats'],

            // === PROMO BANNER ===
            ['key' => 'promo_badge',      'value' => '⚡ Penawaran Spesial',                             'group' => 'promo_banner'],
            ['key' => 'promo_title',      'value' => 'Diskon hingga',                                    'group' => 'promo_banner'],
            ['key' => 'promo_highlight',  'value' => '30%',                                              'group' => 'promo_banner'],
            ['key' => 'promo_subtitle',   'value' => 'untuk produk pilihan kategori Laptop & PC Gaming', 'group' => 'promo_banner'],
            ['key' => 'promo_cta',        'value' => 'Cek Sekarang →',                                   'group' => 'promo_banner'],
            ['key' => 'promo_link_slug',  'value' => 'laptop',                                           'group' => 'promo_banner'],

            // === WHY US ===
            ['key' => 'why_us_title',     'value' => 'Mengapa',       'group' => 'why_us'],
            ['key' => 'why_us_highlight', 'value' => 'TechnoStore?',  'group' => 'why_us'],

            ['key' => 'feature_1_icon',  'value' => '🛡️',            'group' => 'why_us'],
            ['key' => 'feature_1_title', 'value' => 'Produk Original','group' => 'why_us'],
            ['key' => 'feature_1_desc',  'value' => 'Semua produk 100% original dengan garansi resmi dari distributor.', 'group' => 'why_us'],

            ['key' => 'feature_2_icon',  'value' => '🚀',             'group' => 'why_us'],
            ['key' => 'feature_2_title', 'value' => 'Pengiriman Cepat','group' => 'why_us'],
            ['key' => 'feature_2_desc',  'value' => 'Pengiriman ke seluruh Indonesia dengan kurir terpercaya.', 'group' => 'why_us'],

            ['key' => 'feature_3_icon',  'value' => '💳',             'group' => 'why_us'],
            ['key' => 'feature_3_title', 'value' => 'Pembayaran Aman','group' => 'why_us'],
            ['key' => 'feature_3_desc',  'value' => 'Berbagai metode pembayaran tersedia dan 100% aman.', 'group' => 'why_us'],

            ['key' => 'feature_4_icon',  'value' => '🔧',             'group' => 'why_us'],
            ['key' => 'feature_4_title', 'value' => 'Garansi Servis', 'group' => 'why_us'],
            ['key' => 'feature_4_desc',  'value' => 'Layanan purna jual dan garansi servis oleh teknisi berpengalaman.', 'group' => 'why_us'],

            ['key' => 'feature_5_icon',  'value' => '💬',             'group' => 'why_us'],
            ['key' => 'feature_5_title', 'value' => 'Support 24/7',   'group' => 'why_us'],
            ['key' => 'feature_5_desc',  'value' => 'Tim customer service siap membantu Anda kapan saja.', 'group' => 'why_us'],

            ['key' => 'feature_6_icon',  'value' => '🏷️',            'group' => 'why_us'],
            ['key' => 'feature_6_title', 'value' => 'Harga Terbaik',  'group' => 'why_us'],
            ['key' => 'feature_6_desc',  'value' => 'Harga kompetitif dengan kualitas yang tidak perlu diragukan lagi.', 'group' => 'why_us'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'group' => $setting['group']]
            );
        }
    }
}
