@extends('layouts.app')
@section('title', 'Invoice ' . $invoice->invoice_number)

@section('content')
<div class="pt-2 grid grid-cols-1 lg:grid-cols-3 gap-5">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl p-8 shadow-sm ring-1 ring-black/5" id="printable-invoice">
            <div class="flex justify-between items-start pb-6 border-b border-black/10">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <div class="w-8 h-8 rounded-lg bg-[var(--color-thread-gold)] flex items-center justify-center font-display text-sm font-bold text-white">D</div>
                        <span class="font-display text-lg font-semibold">{{ env('SHOP_NAME', 'Darzi Pro') }}</span>
                    </div>
                    <p class="text-xs text-black/40">{{ env('SHOP_CITY', 'Peshawar, KPK') }} · {{ env('SHOP_PHONE', '') }}</p>
                </div>
                <div class="text-right">
                    <p class="font-display text-2xl font-semibold text-[var(--color-thread-teal)]">INVOICE</p>
                    <p class="font-mono text-sm text-black/50">{{ $invoice->invoice_number }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 py-6 border-b border-black/10">
                <div>
                    <p class="text-xs uppercase tracking-wide text-black/40 mb-1">Bill To</p>
                    <p class="font-semibold">{{ $invoice->order->customer->name }}</p>
                    <p class="text-sm text-black/50">{{ $invoice->order->customer->phone }}</p>
                    <p class="text-sm text-black/50">{{ $invoice->order->customer->address }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs uppercase tracking-wide text-black/40 mb-1">Order Ref</p>
                    <p class="font-mono text-sm">{{ $invoice->order->order_number }}</p>
                    <p class="text-xs uppercase tracking-wide text-black/40 mt-2 mb-1">Issue Date</p>
                    <p class="text-sm">{{ $invoice->issue_date->format('d M Y') }}</p>
                </div>
            </div>

            <table class="w-full text-sm my-6">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wide text-black/40 border-b border-black/10">
                        <th class="py-2 font-medium">Item</th>
                        <th class="py-2 font-medium text-center">Qty</th>
                        <th class="py-2 font-medium text-right">Price</th>
                        <th class="py-2 font-medium text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @foreach($invoice->order->items as $item)
                        <tr>
                            <td class="py-3">{{ $item->item_name }} <span class="text-black/40">({{ $item->fabric_style }})</span></td>
                            <td class="py-3 text-center font-mono">{{ $item->quantity }}</td>
                            <td class="py-3 text-right font-mono">{{ number_format($item->unit_price) }}</td>
                            <td class="py-3 text-right font-mono">{{ number_format($item->lineTotal()) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex justify-end">
                <div class="w-64 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-black/50">Subtotal</span><span class="font-mono">Rs. {{ number_format($invoice->amount) }}</span></div>
                    <div class="flex justify-between"><span class="text-black/50">Paid</span><span class="font-mono">Rs. {{ number_format($invoice->paid_amount) }}</span></div>
                    <div class="flex justify-between pt-2 border-t border-black/10 font-semibold"><span>Balance Due</span><span class="font-mono text-[var(--color-terracotta)]">Rs. {{ number_format($invoice->balanceDue()) }}</span></div>
                </div>
            </div>

            <p class="text-center text-xs text-black/30 mt-10 pt-6 border-t border-black/5">Shukriya! Darzi Pro apki khidmat mein hazir hai.</p>
        </div>
    </div>

    <div class="space-y-5">
        <div class="bg-white rounded-xl p-5 shadow-sm ring-1 ring-black/5">
            <p class="text-xs uppercase tracking-wide text-black/40 mb-3">Status</p>
            @php
                $badge = match($invoice->status) {
                    'paid' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                    'partial' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                    default => 'bg-red-50 text-red-700 ring-red-600/20',
                };
            @endphp
            <span class="inline-flex px-3 py-1.5 rounded-full text-sm font-medium ring-1 {{ $badge }}">{{ ucfirst($invoice->status) }}</span>
        </div>

        @if($invoice->balanceDue() > 0)
            <div class="bg-white rounded-xl p-5 shadow-sm ring-1 ring-black/5">
                <p class="text-xs uppercase tracking-wide text-black/40 mb-3">Record Payment</p>
                <form method="POST" action="{{ route('invoices.payment', $invoice) }}" class="flex gap-2">
                    @csrf
                    <input type="number" name="amount" step="0.01" min="0.01" max="{{ $invoice->balanceDue() }}" placeholder="Rs." required
                           class="flex-1 px-3 py-2 rounded-lg border border-black/10 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)]">
                    <button type="submit" class="px-4 py-2 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)]">Add</button>
                </form>
            </div>
        @endif

        <button onclick="window.print()" class="w-full px-4 py-2.5 rounded-lg border border-black/10 text-sm font-medium hover:bg-black/5 flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a1 1 0 001-1v-4a1 1 0 00-1-1H9a1 1 0 00-1 1v4a1 1 0 001 1zm8-12V5a1 1 0 00-1-1H8a1 1 0 00-1 1v4h10z"/></svg>
            Print Invoice
        </button>
    </div>
</div>

<style media="print">
    aside, header, .no-print { display: none !important; }
    #printable-invoice { box-shadow: none !important; }
</style>
@endsection
