<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StyleCategory;

class StyleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Collar (Gala)', 'code' => 'collar', 'sort_order' => 1],
            ['name' => 'Cuff', 'code' => 'cuff', 'sort_order' => 2],
            ['name' => 'Placket (Patti)', 'code' => 'placket', 'sort_order' => 3],
            ['name' => 'Pocket (Jaib)', 'code' => 'pocket', 'sort_order' => 4],
            ['name' => 'Bottom Style (Paincha)', 'code' => 'bottom_style', 'sort_order' => 5],
        ];

        foreach ($categories as $c) {
            StyleCategory::create($c);
        }
    }
}
