<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    /**
     * Tampilkan halaman form pengaturan homepage.
     */
    public function index()
    {
        $settings = SiteSetting::allAsArray();

        return view('admin.settings.index', [
            'title'    => 'Pengaturan',
            'settings' => $settings,
        ]);
    }

    /**
     * Simpan semua pengaturan sekaligus.
     */
    public function update(Request $request)
    {
        $request->validate([
            'store_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);

        // Handle logo upload
        if ($request->hasFile('store_logo')) {
            // Hapus logo lama jika ada
            $oldLogo = SiteSetting::get('store_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('store_logo')->store('logo', 'public');
            SiteSetting::set('store_logo', $path, 'general');
        }

        // Definisi grup untuk setiap key
        $groups = [
            // General / Toko
            'store_name'        => 'general',
            'store_tagline'     => 'general',
            'store_description' => 'general',
            'store_address'     => 'general',
            'store_phone'       => 'general',
            'store_email'       => 'general',

            // Hero
            'hero_badge'           => 'hero',
            'hero_title'           => 'hero',
            'hero_title_highlight' => 'hero',
            'hero_subtitle'        => 'hero',
            'hero_cta_primary'     => 'hero',
            'hero_cta_secondary'   => 'hero',

            // Stats
            'stat_1_value' => 'stats',
            'stat_1_label' => 'stats',
            'stat_2_value' => 'stats',
            'stat_2_label' => 'stats',
            'stat_3_value' => 'stats',
            'stat_3_label' => 'stats',

            // Promo banner
            'promo_badge'     => 'promo_banner',
            'promo_title'     => 'promo_banner',
            'promo_highlight' => 'promo_banner',
            'promo_subtitle'  => 'promo_banner',
            'promo_cta'       => 'promo_banner',
            'promo_link_slug' => 'promo_banner',

            // Why us
            'why_us_title'     => 'why_us',
            'why_us_highlight' => 'why_us',
            'feature_1_icon'   => 'why_us', 'feature_1_title' => 'why_us', 'feature_1_desc' => 'why_us',
            'feature_2_icon'   => 'why_us', 'feature_2_title' => 'why_us', 'feature_2_desc' => 'why_us',
            'feature_3_icon'   => 'why_us', 'feature_3_title' => 'why_us', 'feature_3_desc' => 'why_us',
            'feature_4_icon'   => 'why_us', 'feature_4_title' => 'why_us', 'feature_4_desc' => 'why_us',
            'feature_5_icon'   => 'why_us', 'feature_5_title' => 'why_us', 'feature_5_desc' => 'why_us',
            'feature_6_icon'   => 'why_us', 'feature_6_title' => 'why_us', 'feature_6_desc' => 'why_us',
        ];

        $data = $request->except(['_token', '_method', 'store_logo']);

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $groups)) {
                SiteSetting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value, 'group' => $groups[$key]]
                );
            }
        }

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }

    /**
     * Hapus logo toko.
     */
    public function deleteLogo()
    {
        $logo = SiteSetting::get('store_logo');
        if ($logo && Storage::disk('public')->exists($logo)) {
            Storage::disk('public')->delete($logo);
        }
        SiteSetting::set('store_logo', null, 'general');

        return back()->with('success', 'Logo berhasil dihapus.');
    }
}
