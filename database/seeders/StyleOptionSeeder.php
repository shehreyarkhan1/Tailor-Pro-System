<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StyleOption;
use App\Models\StyleCategory;

class StyleOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'collar' => [
                ['name' => 'Peshawari Collar', 'code' => 'peshawari', 'swatch_color' => '#0F5C56', 'icon_path' => 'icons/collars/peshawari.svg', 'extra_price' => 200, 'description' => 'Traditional round-edge Peshawari style collar'],
                ['name' => 'Mandarin Collar', 'code' => 'mandarin', 'swatch_color' => '#C08829', 'icon_path' => 'icons/collars/mandarin.svg', 'extra_price' => 0, 'description' => 'Simple band-style stand collar'],
                ['name' => 'Classic Point Collar', 'code' => 'classic_point', 'swatch_color' => '#6B7280', 'icon_path' => 'icons/collars/classic_point.svg', 'extra_price' => 0, 'description' => 'Standard pointed shirt-style collar'],
                ['name' => 'Band Collar (No Collar)', 'code' => 'band', 'swatch_color' => '#B23A2E', 'icon_path' => 'icons/collars/band.svg', 'extra_price' => 0, 'description' => 'Minimal thin band, no fold'],
            ],
            'cuff' => [
                ['name' => 'Single Button Cuff', 'code' => 'single_button', 'swatch_color' => '#0F5C56', 'icon_path' => 'icons/cuffs/single_button.svg', 'extra_price' => 0],
                ['name' => 'Double Button Cuff', 'code' => 'double_button', 'swatch_color' => '#C08829', 'icon_path' => 'icons/cuffs/double_button.svg', 'extra_price' => 100],
                ['name' => 'Round Open Cuff', 'code' => 'round_open', 'swatch_color' => '#6B7280', 'icon_path' => 'icons/cuffs/round_open.svg', 'extra_price' => 0],
            ],
            'placket' => [
                ['name' => 'Plain Patti', 'code' => 'plain', 'swatch_color' => '#0F5C56', 'icon_path' => 'icons/plackets/plain.svg', 'extra_price' => 0],
                ['name' => 'Double Patti', 'code' => 'double', 'swatch_color' => '#C08829', 'icon_path' => 'icons/plackets/double.svg', 'extra_price' => 150],
                ['name' => 'Hidden Button Placket', 'code' => 'hidden_button', 'swatch_color' => '#2F7D52', 'icon_path' => 'icons/plackets/hidden_button.svg', 'extra_price' => 250],
            ],
            'pocket' => [
                ['name' => 'Single Left Pocket', 'code' => 'single_left', 'swatch_color' => '#0F5C56', 'icon_path' => 'icons/pockets/single_left.svg', 'extra_price' => 0],
                ['name' => 'Double Pocket', 'code' => 'double', 'swatch_color' => '#C08829', 'icon_path' => 'icons/pockets/double.svg', 'extra_price' => 100],
                ['name' => 'Patch Pocket (Kaj)', 'code' => 'patch', 'swatch_color' => '#6B7280', 'icon_path' => 'icons/pockets/patch.svg', 'extra_price' => 150],
                ['name' => 'No Pocket', 'code' => 'none', 'swatch_color' => '#B23A2E', 'icon_path' => 'icons/pockets/none.svg', 'extra_price' => 0],
            ],
            'bottom_style' => [
                ['name' => 'Straight Paincha', 'code' => 'straight', 'swatch_color' => '#0F5C56', 'icon_path' => 'icons/bottoms/straight.svg', 'extra_price' => 0],
                ['name' => 'Chust (Tight) Paincha', 'code' => 'chust', 'swatch_color' => '#C08829', 'icon_path' => 'icons/bottoms/chust.svg', 'extra_price' => 0],
                ['name' => 'Pajama Style', 'code' => 'pajama', 'swatch_color' => '#2F7D52', 'icon_path' => 'icons/bottoms/pajama.svg', 'extra_price' => 100],
            ],
        ];

        foreach ($data as $categoryCode => $options) {
            $category = StyleCategory::where('code', $categoryCode)->firstOrFail();

            foreach ($options as $i => $option) {
                $option['style_category_id'] = $category->id;
                $option['sort_order'] = $i + 1;
                StyleOption::create($option);
            }
        }
    }
}
