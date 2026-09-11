@extends('layouts.app')
@section('title', 'Generate Invoice')

@section('content')
<div class="pt-2 max-w-xl">
    <div class="bg-white rounded-xl p-6 sm:p-8 shadow-sm ring-1 ring-black/5">
        <p class="text-sm text-black/50 mb-1">Order <span class="font-mono">{{ $order->order_number }}</span></p>
        <h3 class="font-display text-lg font-semibold mb-6">{{ $order->customer->name }}</h3>

        <form method="POST" action="{{ route('invoices.store', $order) }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1.5">Total Amount (Rs.)</label>
                <input type="number" name="amount" value="{{ $order->total_amount }}" step="0.01" required
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm font-mono">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Paid Amount (Rs.)</label>
                <input type="number" name="paid_amount" value="{{ $order->advance_paid }}" step="0.01" required
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm font-mono">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Issue Date</label>
                <input type="date" name="issue_date" value="{{ now()->format('Y-m-d') }}" required
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-[var(--color-thread-gold)] text-white text-sm font-semibold hover:opacity-90">Generate Invoice</button>
                <a href="{{ route('orders.show', $order) }}" class="px-5 py-2.5 rounded-lg border border-black/10 text-sm font-medium hover:bg-black/5">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
