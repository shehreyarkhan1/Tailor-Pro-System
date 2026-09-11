@extends('layouts.app')
@section('title', $customer->name)
@section('subtitle', $customer->customer_code . ' · ' . $customer->city)

@section('content')
    <div x-data="{ tab: 'measurements' }" class="pt-2 space-y-5">
        <!-- Profile header -->
        <div
            class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-16 h-16 rounded-full bg-[var(--color-thread-teal)]/10 text-[var(--color-thread-teal)] flex items-center justify-center font-display text-2xl font-semibold">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="font-display text-xl font-semibold">{{ $customer->name }}</h2>
                        @if ($customer->is_vip)
                            <span
                                class="px-2 py-0.5 rounded-full bg-[var(--color-thread-gold)]/15 text-[var(--color-thread-gold)] text-[10px] font-bold uppercase">VIP</span>
                        @endif
                    </div>
                    <p class="text-sm text-black/50 mt-0.5">{{ $customer->phone }} @if ($customer->whatsapp)
                            · WhatsApp: {{ $customer->whatsapp }}
                        @endif
                    </p>
                    <p class="text-sm text-black/40">{{ $customer->address ?? $customer->city }}</p>
                </div>
            </div>
            <div class="flex gap-2" x-data="{ menuOpen: false }">
                @if (Route::has('orders.create'))
                    <a href="{{ route('orders.create', ['customer_id' => $customer->id]) }}"
                        class="px-4 py-2 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)]">
                        + New Order
                    </a>
                @endif

                <div class="relative">
                    <button @click="menuOpen = !menuOpen" @click.outside="menuOpen = false"
                        class="w-9 h-9 flex items-center justify-center rounded-lg border border-black/10 hover:bg-black/5 transition-colors">
                        <svg class="w-4 h-4 text-black/50" fill="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="5" r="1.75" />
                            <circle cx="12" cy="12" r="1.75" />
                            <circle cx="12" cy="19" r="1.75" />
                        </svg>
                    </button>

                    <div x-show="menuOpen" x-cloak x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg ring-1 ring-black/5 py-1.5 z-20">
                        @if (Route::has('customers.edit'))
                            <a href="{{ route('customers.edit', $customer) }}"
                                class="flex items-center gap-2.5 px-3.5 py-2 text-sm text-[var(--color-ink)] hover:bg-black/5 transition-colors">
                                <svg class="w-4 h-4 text-black/40" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="1.75">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit Customer
                            </a>
                        @endif

                        @if (Route::has('customers.destroy'))
                            <div class="my-1 border-t border-black/5"></div>
                            <form method="POST" action="{{ route('customers.destroy', $customer) }}"
                                onsubmit="return confirm('Kya aap sure hain? {{ $customer->name }} aur uski tamam naapain/orders ka data delete ho jayega. Ye action wapis nahi ho sakta.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-3.5 py-2 text-sm text-[var(--color-terracotta)] hover:bg-[var(--color-terracotta)]/5 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="1.75">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Customer
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <!-- Tabs -->
        <div class="border-b border-black/10 flex gap-6">
            <button @click="tab = 'measurements'"
                :class="tab === 'measurements' ? 'border-[var(--color-thread-teal)] text-[var(--color-thread-teal)]' :
                    'border-transparent text-black/40'"
                class="pb-3 border-b-2 text-sm font-semibold transition-colors">Measurements
                ({{ $customer->measurements->count() }})</button>
            <button @click="tab = 'orders'"
                :class="tab === 'orders' ? 'border-[var(--color-thread-teal)] text-[var(--color-thread-teal)]' :
                    'border-transparent text-black/40'"
                class="pb-3 border-b-2 text-sm font-semibold transition-colors">Order History
                ({{ $customer->orders->count() }})</button>
            <button @click="tab = 'add'"
                :class="tab === 'add' ? 'border-[var(--color-thread-teal)] text-[var(--color-thread-teal)]' :
                    'border-transparent text-black/40'"
                class="pb-3 border-b-2 text-sm font-semibold transition-colors">+ Add Naap</button>
        </div>

        <!-- Measurements tab -->
        <div x-show="tab === 'measurements'" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @forelse($customer->measurements as $m)
                <div class="bg-white rounded-xl p-5 shadow-sm ring-1 ring-black/5">
                    <div class="flex justify-between items-center mb-3">
                        <span class="font-semibold text-sm capitalize">{{ str_replace('_', ' ', $m->garment_type) }}</span>
                        <span class="text-xs text-black/40">{{ $m->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="grid grid-cols-3 gap-y-2 text-sm">
                        @foreach (['length' => 'Length', 'chest' => 'Chest', 'waist' => 'Waist', 'shoulder' => 'Shoulder', 'sleeve_length' => 'Sleeve', 'collar' => 'Collar', 'shalwar_length' => 'Shalwar', 'paincha' => 'Paincha', 'armhole' => 'Armhole'] as $field => $label)
                            @if ($m->$field)
                                <div>
                                    <p class="text-[10px] uppercase text-black/35">{{ $label }}</p>
                                    <p class="font-mono font-medium">{{ $m->$field }}"</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @if ($m->style_notes)
                        <p class="mt-3 pt-3 border-t border-black/5 text-xs text-black/50 italic">{{ $m->style_notes }}</p>
                    @endif
                </div>
            @empty
                <div class="col-span-full bg-white rounded-xl p-10 text-center ring-1 ring-black/5 text-black/40">Abhi tak
                    koi naap save nahi hui.</div>
            @endforelse
        </div>

        <!-- Orders tab -->
        <div x-show="tab === 'orders'" class="bg-white rounded-xl shadow-sm ring-1 ring-black/5 overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wide text-black/40 border-b border-black/5">
                        <th class="px-6 py-3 font-medium">Order #</th>
                        <th class="px-6 py-3 font-medium">Order Date</th>
                        <th class="px-6 py-3 font-medium">Delivery</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse($customer->orders as $order)
                        <tr class="hover:bg-black/[0.02] cursor-pointer"
                            onclick="window.location='{{ route('orders.show', $order) }}'">
                            <td class="px-6 py-3.5 font-mono text-xs">{{ $order->order_number }}</td>
                            <td class="px-6 py-3.5 text-black/60">{{ $order->order_date->format('d M Y') }}</td>
                            <td class="px-6 py-3.5 text-black/60">{{ $order->delivery_date->format('d M Y') }}</td>
                            <td class="px-6 py-3.5"><span
                                    class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium ring-1 {{ $order->statusColor() }}">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td class="px-6 py-3.5 text-right font-mono">Rs. {{ number_format($order->total_amount) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-black/40">Koi order history nahi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Add measurement tab -->
        <div x-show="tab === 'add'" class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5 max-w-3xl">
            @if (Route::has('customers.measurements.store'))
                <form method="POST" action="{{ route('customers.measurements.store', $customer) }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Garment Type</label>
                        <select name="garment_type"
                            class="w-full sm:w-64 px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                            <option value="shalwar_qameez">Shalwar Qameez</option>
                            <option value="kurta_pajama">Kurta Pajama</option>
                            <option value="waistcoat">Waistcoat</option>
                            <option value="coat_pant">Coat Pant</option>
                            <option value="kids_wear">Kids Wear</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        @foreach ([
            'length' => 'Length',
            'chest' => 'Chest',
            'waist' => 'Waist',
            'hips' => 'Hips',
            'shoulder' => 'Shoulder',
            'sleeve_length' => 'Sleeve Length',
            'collar' => 'Collar',
            'armhole' => 'Armhole',
            'bicep' => 'Bicep',
            'shalwar_length' => 'Shalwar Length',
            'paincha' => 'Paincha (bottom)',
        ] as $field => $label)
                            <div>
                                <label class="block text-xs font-medium text-black/50 mb-1">{{ $label }}
                                    (in)
                                </label>
                                <input type="number" step="0.1" name="{{ $field }}"
                                    class="w-full px-3 py-2 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm font-mono">
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1.5">Style Notes</label>
                        <textarea name="style_notes" rows="2" placeholder="e.g. Peshawari collar, 2 jaib, chust pajama..."
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm"></textarea>
                    </div>

                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)]">Save
                        Measurement</button>
                </form>
            @endif
        </div>
    </div>
@endsection
