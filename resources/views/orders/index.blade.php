@extends('layouts.app')
@section('title', 'Orders')
@section('subtitle', $orders->total() . ' total orders')

@section('content')
<div class="pt-2 space-y-5">
    <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
        <form method="GET" class="flex flex-1 gap-3 max-w-2xl">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-black/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Order # ya customer naam..."
                       class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)]">
            </div>
            <select name="status" onchange="this.form.submit()" class="px-3 py-2.5 rounded-lg border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)]">
                <option value="">Sab Status</option>
                @foreach(['pending','cutting','stitching','finishing','ready','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </form>
        @if (Route::has('orders.create'))
        <a href="{{ route('orders.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)] transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Naya Order
        </a>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm ring-1 ring-black/5 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs uppercase tracking-wide text-black/40 border-b border-black/5">
                    <th class="px-6 py-3 font-medium">Order #</th>
                    <th class="px-6 py-3 font-medium">Customer</th>
                    <th class="px-6 py-3 font-medium">Karigar</th>
                    <th class="px-6 py-3 font-medium">Delivery</th>
                    <th class="px-6 py-3 font-medium">Status</th>
                    <th class="px-6 py-3 font-medium text-right">Amount</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse ($orders as $order)
                    <tr class="hover:bg-black/[0.02] cursor-pointer" onclick="window.location='{{ route('orders.show', $order) }}'">
                        <td class="px-6 py-3.5 font-mono text-xs text-black/60">
                            {{ $order->order_number }}
                            @if($order->priority === 'urgent')
                                <span class="ml-1.5 px-1.5 py-0.5 rounded bg-[var(--color-terracotta)]/10 text-[var(--color-terracotta)] text-[10px] font-bold uppercase">Urgent</span>
                            @endif
                        </td>
                        <td class="px-6 py-3.5 font-medium">{{ $order->customer->name }}</td>
                        <td class="px-6 py-3.5 text-black/50">{{ $order->assignedStaff->name ?? '—' }}</td>
                        <td class="px-6 py-3.5 {{ $order->delivery_date->isPast() && !in_array($order->status, ['delivered','cancelled']) ? 'text-[var(--color-terracotta)] font-medium' : 'text-black/60' }}">
                            {{ $order->delivery_date->format('d M Y') }}
                        </td>
                        <td class="px-6 py-3.5">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium ring-1 {{ $order->statusColor() }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="px-6 py-3.5 text-right font-mono">Rs. {{ number_format($order->total_amount) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-12 text-center text-black/40">Koi order nahi mila.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $orders->links() }}</div>
</div>
@endsection
