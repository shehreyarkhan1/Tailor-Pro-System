<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Order;
use App\Models\StyleCategory ;
use App\Models\Staff;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['pending', 'cutting', 'stitching', 'finishing', 'delivered'];
        $staffIds = Staff::pluck('id');
        $categories = StyleCategory::with('activeOptions')->get();

        Customer::with('measurements')->get()->each(function (Customer $customer, int $i) use ($statuses, $staffIds, $categories) {
            $status = $statuses[$i % count($statuses)];
            $measurement = $customer->measurements->first();

            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_id' => $customer->id,
                'measurement_id' => $measurement?->id,
                'assigned_staff_id' => $staffIds->random(),
                'order_date' => now()->subDays(rand(1, 12)),
                'delivery_date' => now()->addDays(rand(1, 8)),
                'status' => $status,
                'priority' => $i === 0 ? 'urgent' : 'normal',
                'total_amount' => 0, // calculated below
                'advance_paid' => 1000,
                'notes' => null,
            ]);

            // Order item (Shalwar Qameez base price)
            $item = $order->items()->create([
                'item_name' => 'Shalwar Qameez',
                'fabric_style' => collect(['Wash n Wear', 'Cotton', 'Karandi', 'Boski'])->random(),
                'quantity' => rand(1, 2),
                'unit_price' => 2500,
            ]);

            $itemsTotal = $item->quantity * $item->unit_price;

            // Randomly pick one style option per category, add its extra_price to total
            $stylePriceAddOn = 0;
            foreach ($categories as $category) {
                $chosenOption = $category->activeOptions->random();

                $order->styleSelections()->create([
                    'style_category_id' => $category->id,
                    'style_option_id' => $chosenOption->id,
                ]);

                $stylePriceAddOn += $chosenOption->extra_price;
            }

            $order->update(['total_amount' => $itemsTotal + $stylePriceAddOn]);
        });
    }
}
