<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Laptop',
                'slug' => 'laptop',
                'icon' => '💻',
                'description' => 'Laptop untuk produktivitas, gaming, dan desain.',
                'sort_order' => 1,
            ],
            [
                'name' => 'PC Desktop',
                'slug' => 'pc-desktop',
                'icon' => '🖥️',
                'description' => 'Komputer desktop rakitan dan branded untuk kantor dan gaming.',
                'sort_order' => 2,
            ],
            [
                'name' => 'Monitor',
                'slug' => 'monitor',
                'icon' => '🖵',
                'description' => 'Monitor IPS, VA, dan gaming dengan refresh rate tinggi.',
                'sort_order' => 3,
            ],
            [
                'name' => 'Komponen PC',
                'slug' => 'komponen-pc',
                'icon' => '⚙️',
                'description' => 'Prosesor, RAM, VGA, SSD, dan komponen PC lainnya.',
                'sort_order' => 4,
            ],
            [
                'name' => 'Aksesoris',
                'slug' => 'aksesoris',
                'icon' => '🖱️',
                'description' => 'Mouse, keyboard, headset, dan aksesoris gaming.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Jaringan',
                'slug' => 'jaringan',
                'icon' => '📡',
                'description' => 'Router, switch, access point, dan perangkat jaringan.',
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
