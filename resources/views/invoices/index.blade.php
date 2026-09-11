@extends('layouts.app')
@section('title', 'Billing')
@section('subtitle', $invoices->total() . ' invoices generated')

@section('content')
<div class="pt-2 space-y-5">
    <form method="GET" class="flex gap-3">
        <select name="status" onchange="this.form.submit()" class="px-3 py-2.5 rounded-lg border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)]">
            <option value="">Sab Status</option>
            @foreach(['unpaid' => 'Unpaid', 'partial' => 'Partial', 'paid' => 'Paid'] as $val => $label)
                <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
            @endforeach
        </select>
    </form>

    <div class="bg-white rounded-xl shadow-sm ring-1 ring-black/5 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs uppercase tracking-wide text-black/40 border-b border-black/5">
                    <th class="px-6 py-3 font-medium">Invoice #</th>
                    <th class="px-6 py-3 font-medium">Customer</th>
                    <th class="px-6 py-3 font-medium">Issue Date</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium text-right">Amount</th>
                    <th class="px-6 py-3 font-medium text-right">Balance</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse ($invoices as $invoice)
                    <tr class="hover:bg-black/[0.02] cursor-pointer" onclick="window.location='{{ route('invoices.show', $invoice) }}'">
                        <td class="px-6 py-3.5 font-mono text-xs">{{ $invoice->invoice_number }}</td>
                        <td class="px-6 py-3.5 font-medium">{{ $invoice->order->customer->name }}</td>
                        <td class="px-6 py-3.5 text-black/60">{{ $invoice->issue_date->format('d M Y') }}</td>
                        <td class="px-6 py-3.5">
                            @php
                                $badge = match($invoice->status) {
                                    'paid' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                    'partial' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                                    default => 'bg-red-50 text-red-700 ring-red-600/20',
                                };
                            @endphp
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium ring-1 {{ $badge }}">{{ ucfirst($invoice->status) }}</span>
                        </td>
                        <td class="px-6 py-3.5 text-right font-mono">Rs. {{ number_format($invoice->amount) }}</td>
                        <td class="px-6 py-3.5 text-right font-mono {{ $invoice->balanceDue() > 0 ? 'text-[var(--color-terracotta)] font-semibold' : 'text-black/40' }}">Rs. {{ number_format($invoice->balanceDue()) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-black/40">Koi invoice nahi mila.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $invoices->links() }}</div>
</div>
@endsection
