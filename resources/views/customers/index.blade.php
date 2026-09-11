@extends('layouts.app')
@section('title', 'Customers')
@section('subtitle', $customers->total() . ' registered customers')

@section('content')
<div class="pt-2 space-y-5">
    <div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
        <form method="GET" class="relative flex-1 max-w-sm">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-black/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, phone or code..."
                   class="w-full pl-9 pr-3 py-2.5 rounded-lg border border-black/10 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)]">
        </form>
        <a href="{{ route('customers.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)] transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Naya Customer
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse ($customers as $customer)
            <a href="{{ route('customers.show', $customer) }}" class="bg-white rounded-xl p-5 shadow-sm ring-1 ring-black/5 hover:ring-[var(--color-thread-teal)]/30 hover:shadow-md transition-all">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-[var(--color-thread-teal)]/10 text-[var(--color-thread-teal)] flex items-center justify-center font-display font-semibold">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-sm">{{ $customer->name }}</p>
                            <p class="text-xs text-black/40 font-mono">{{ $customer->customer_code }}</p>
                        </div>
                    </div>
                    @if($customer->is_vip)
                        <span class="px-2 py-0.5 rounded-full bg-[var(--color-thread-gold)]/15 text-[var(--color-thread-gold)] text-[10px] font-bold uppercase tracking-wide">VIP</span>
                    @endif
                </div>
                <div class="text-sm text-black/60 space-y-1">
                    <p class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-black/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>{{ $customer->phone }}</p>
                    <p class="flex items-center gap-2"><svg class="w-3.5 h-3.5 text-black/30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>{{ $customer->city }}</p>
                </div>
                <div class="mt-4 pt-3 border-t border-black/5 flex justify-between text-xs">
                    <span class="text-black/40">Total Orders</span>
                    <span class="font-semibold font-mono">{{ $customer->orders_count }}</span>
                </div>
            </a>
        @empty
            <div class="col-span-full bg-white rounded-xl p-12 text-center ring-1 ring-black/5">
                <p class="text-black/40">There is not customer, Add The customers.</p>
            </div>
        @endforelse
    </div>

    <div>{{ $customers->links() }}</div>
</div>
@endsection
