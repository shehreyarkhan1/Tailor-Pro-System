<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $staff = [
            ['name' => 'Ustad Fazal Rahim', 'role' => 'master_tailor', 'phone' => '0333-1234567', 'monthly_salary' => 45000],
            ['name' => 'Bilal Khan', 'role' => 'cutter', 'phone' => '0345-2345678', 'monthly_salary' => 30000],
            ['name' => 'Naveed Ahmad', 'role' => 'stitcher', 'phone' => '0301-3456789', 'monthly_salary' => 28000],
            ['name' => 'Imran Shah', 'role' => 'finisher', 'phone' => '0312-4567890', 'monthly_salary' => 25000],
            ['name' => 'Shahid Ali', 'role' => 'stitcher', 'phone' => '0333-5678901', 'monthly_salary' => 27000],
            ['name' => 'Waqas Manager', 'role' => 'manager', 'phone' => '0300-6789012', 'monthly_salary' => 40000],
        ];

        foreach ($staff as $s) {
            Staff::create($s);
        }
    }
}
