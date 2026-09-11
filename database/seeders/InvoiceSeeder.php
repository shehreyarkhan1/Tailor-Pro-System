<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Invoice;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::where('status', 'delivered')->get()->each(function (Order $order) {
            Invoice::create([
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'order_id' => $order->id,
                'amount' => $order->total_amount,
                'paid_amount' => $order->total_amount,
                'status' => 'paid',
                'issue_date' => now()->subDays(1),

            ]);
        });

        $pendingOrder = Order::where('status', '!=', 'delivered')->first();
        if ($pendingOrder) {
            Invoice::create([
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'order_id' => $pendingOrder->id,
                'amount' => $pendingOrder->total_amount,
                'paid_amount' => $pendingOrder->advance_paid,
                'status' => $pendingOrder->advance_paid > 0 ? 'partial' : 'unpaid',
                'issue_date' => now(),
            ]);
        }
    }
}
