<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{

     public function run(): void
    {
        $customers = [
            ['name' => 'Malik Zahid Iqbal', 'phone' => '0300-1111111', 'whatsapp' => '0300-1111111', 'gender' => 'male', 'city' => 'Peshawar', 'is_vip' => true, 'address' => 'University Town, Peshawar'],
            ['name' => 'Sana Gul', 'phone' => '0333-2222222', 'gender' => 'female', 'city' => 'Mardan', 'address' => 'Bank Road, Mardan'],
            ['name' => 'Haroon Rasheed', 'phone' => '0345-3333333', 'gender' => 'male', 'city' => 'Swat', 'address' => 'Mingora Bazar, Swat'],
            ['name' => 'Ayesha Bibi', 'phone' => '0301-4444444', 'gender' => 'female', 'city' => 'Peshawar', 'address' => 'Hayatabad Phase 3'],
            ['name' => 'Junaid Afridi', 'phone' => '0312-5555555', 'gender' => 'male', 'city' => 'Charsadda'],
            ['name' => 'Fahad Wazir', 'phone' => '0345-6666666', 'gender' => 'male', 'city' => 'Peshawar', 'is_vip' => true],
            ['name' => 'Bushra Khan', 'phone' => '0301-7777777', 'gender' => 'female', 'city' => 'Nowshera'],
            ['name' => 'Kamran Khattak', 'phone' => '0333-8888888', 'gender' => 'male', 'city' => 'Kohat'],
        ];

        foreach ($customers as $c) {
            $c['customer_code'] = Customer::generateCode();
            Customer::create($c);
        }
    }
}
