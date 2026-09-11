<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Customer;
use App\Models\Measurement;

class MeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::all()->each(function (Customer $customer){
            Measurement::create([
                'customer_id'=> $customer->id,
                'garment_type'=>$customer->gender === 'kids' ? 'kids-wear' : 'shalwar_qameez',
                'length'=> rand(38,44),
                'chest'=> rand(36, 44),
                'waist'=> rand(30, 38),
                'hips'=> rand(38,44),
                'shoulder'=>rand(17,22),
                'sleeve_length'=> rand(22, 25),
                'collar'=> rand(15,17),
                'armhole'=> rand(18,22),
                'bicep'=> rand(12,16),
                'shalwar_length'=> rand(38,42),
                'paincha'=> rand(14,18),
                'style_notes'=> 'standard fitting, Customer preference notes wirte here',
            ]);
        });
    }
}
