@extends('layouts.app')
@section('title', $order->order_number)
@section('subtitle', 'Order placed ' . $order->order_date->format('d M Y'))

@section('content')
    <div class="pt-2 grid grid-cols-1 lg:grid-cols-3 gap-5">

        <div class="lg:col-span-2 space-y-5">
            <!-- Status timeline -->
            <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-display text-lg font-semibold">Order Progress</h3>
                    @if ($order->priority === 'urgent')
                        <span
                            class="px-2.5 py-1 rounded-full bg-[var(--color-terracotta)]/10 text-[var(--color-terracotta)] text-xs font-bold uppercase">Urgent</span>
                    @endif
                </div>

                @php
                    $steps = [
                        'pending' => 'Pending',
                        'cutting' => 'Cutting',
                        'stitching' => 'Stitching',
                        'finishing' => 'Finishing',
                        'ready' => 'Ready',
                        'delivered' => 'Delivered',
                    ];
                    $currentIndex = array_search($order->status, array_keys($steps));
                @endphp

                @if ($order->status === 'cancelled')
                    <div class="px-4 py-3 rounded-lg bg-red-50 text-red-700 text-sm font-medium ring-1 ring-red-200">The
                        Order has canceled .</div>
                @else
                    <div class="flex items-center">
                        @foreach ($steps as $key => $label)
                            @php
                                $idx = array_search($key, array_keys($steps));
                                $done = $idx <= $currentIndex;
                            @endphp
                            <div class="flex-1 flex flex-col items-center relative">
                                @if ($idx > 0)
                                    <div
                                        class="absolute right-1/2 top-3 h-0.5 w-full {{ $idx <= $currentIndex ? 'bg-[var(--color-thread-teal)]' : 'bg-black/10' }}">
                                    </div>
                                @endif
                                <div
                                    class="relative z-10 w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold {{ $done ? 'bg-[var(--color-thread-teal)] text-white' : 'bg-black/10 text-black/40' }}">
                                    @if ($done && $idx < $currentIndex)
                                        ✓@else{{ $idx + 1 }}
                                    @endif
                                </div>
                                <span
                                    class="mt-2 text-[11px] font-medium {{ $done ? 'text-[var(--color-thread-teal)]' : 'text-black/40' }} text-center">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if (Route::has('orders.status'))
                    <form method="POST" action="{{ route('orders.status', $order) }}"
                        class="mt-6 pt-5 border-t border-black/5 flex items-center gap-3">
                        @csrf @method('PATCH')
                        <label class="text-sm font-medium text-black/60">Update Status:</label>
                        <select name="status" onchange="this.form.submit()"
                            class="px-3 py-2 rounded-lg border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)]">
                            @foreach (array_merge($steps, ['cancelled' => 'Cancelled']) as $key => $label)
                                <option value="{{ $key }}" @selected($order->status === $key)>{{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </div>

            <!-- Items -->
            <div class="bg-white rounded-xl shadow-sm ring-1 ring-black/5 overflow-hidden">
                <div class="px-6 py-4 border-b border-black/5">
                    <h3 class="font-display text-lg font-semibold">Items</h3>
                </div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs uppercase tracking-wide text-black/40 border-b border-black/5">
                            <th class="px-6 py-3 font-medium">Item</th>
                            <th class="px-6 py-3 font-medium">Fabric</th>
                            <th class="px-6 py-3 font-medium text-center">Qty</th>
                            <th class="px-6 py-3 font-medium text-right">Unit Price</th>
                            <th class="px-6 py-3 font-medium text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5">
                        @foreach ($order->items as $item)
                            <tr>
                                <td class="px-6 py-3.5 font-medium">{{ $item->item_name }}</td>
                                <td class="px-6 py-3.5 text-black/50">{{ $item->fabric_style ?? '—' }}</td>
                                <td class="px-6 py-3.5 text-center font-mono">{{ $item->quantity }}</td>
                                <td class="px-6 py-3.5 text-right font-mono">Rs. {{ number_format($item->unit_price, 0) }}
                                </td>
                                <td class="px-6 py-3.5 text-right font-mono font-semibold">Rs.
                                    {{ number_format($item->lineTotal(), 0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($order->styleSelections->isNotEmpty())
                <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                    <h3 class="font-display text-lg font-semibold mb-4">Style Selection</h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach ($order->styleSelections as $selection)
                            <div
                                class="flex items-center gap-2.5 pl-2.5 pr-4 py-2 rounded-xl bg-[var(--color-cloth)] ring-1 ring-black/5">
                                <span
                                    class="relative w-7 h-7 rounded-full shrink-0 flex items-center justify-center ring-1 ring-black/5"
                                    style="background-color: {{ $selection->option->swatch_color ?? '#E5E5E5' }}">
                                    @if ($selection->option->icon_path)
                                        <img src="{{ $selection->option->iconUrl() }}" class="w-4 h-4" alt=""
                                            onerror="this.remove()">
                                    @endif
                                </span>
                                <span>
                                    <span
                                        class="block text-[10px] uppercase tracking-wide text-black/40">{{ $selection->category->name }}</span>
                                    <span
                                        class="block text-sm font-medium leading-tight">{{ $selection->option->name }}</span>
                                </span>
                                @if ($selection->option->extra_price > 0)
                                    <span class="ml-1 text-xs font-mono text-[var(--color-thread-gold)]">+Rs.
                                        {{ number_format($selection->option->extra_price) }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($order->measurement)
                <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
                    <h3 class="font-display text-lg font-semibold mb-4">Measurement Used</h3>
                    <div class="grid grid-cols-3 sm:grid-cols-5 gap-y-3">
                        @foreach (['length' => 'Length', 'chest' => 'Chest', 'waist' => 'Waist', 'shoulder' => 'Shoulder', 'sleeve_length' => 'Sleeve', 'collar' => 'Collar', 'shalwar_length' => 'Shalwar', 'paincha' => 'Paincha'] as $field => $label)
                            @if ($order->measurement->$field)
                                <div>
                                    <p class="text-[10px] uppercase text-black/35">{{ $label }}</p>
                                    <p class="font-mono font-medium text-sm">{{ $order->measurement->$field }}"</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="space-y-5">
            <!-- Customer card -->
            <div class="bg-white rounded-xl p-5 shadow-sm ring-1 ring-black/5">
                <p class="text-xs uppercase tracking-wide text-black/40 mb-3">Customer</p>
                @if (Route::has('customers.show'))
                    <a href="{{ route('customers.show', $order->customer) }}"
                        class="flex items-center gap-3 hover:opacity-80">
                        <div
                            class="w-11 h-11 rounded-full bg-[var(--color-thread-teal)]/10 text-[var(--color-thread-teal)] flex items-center justify-center font-display font-semibold">
                            {{ strtoupper(substr($order->customer->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-sm">{{ $order->customer->name }}</p>
                            <p class="text-xs text-black/40">{{ $order->customer->phone }}</p>
                        </div>
                    </a>
                @endif
            </div>

            <!-- Assign staff -->
            <div class="bg-white rounded-xl p-5 shadow-sm ring-1 ring-black/5">
                <p class="text-xs uppercase tracking-wide text-black/40 mb-3">Assigned Karigar</p>
                @if (Route::has('orders.assign'))
                    <form method="POST" action="{{ route('orders.assign', $order) }}">
                        @csrf @method('PATCH')
                        <select name="assigned_staff_id" onchange="this.form.submit()"
                            class="w-full px-3 py-2.5 rounded-lg border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)]">
                            <option value="">— Unassigned —</option>
                            @foreach ($staff as $s)
                                <option value="{{ $s->id }}" @selected($order->assigned_staff_id === $s->id)>{{ $s->name }}
                                    ({{ $s->roleLabel() }})
                                </option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </div>

            <!-- Payment summary -->
            <div class="bg-white rounded-xl p-5 shadow-sm ring-1 ring-black/5">
                <p class="text-xs uppercase tracking-wide text-black/40 mb-3">Payment Summary</p>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-black/50">Total Amount</span><span
                            class="font-mono font-semibold">Rs. {{ number_format($order->total_amount) }}</span></div>
                    <div class="flex justify-between"><span class="text-black/50">Advance Paid</span><span
                            class="font-mono">Rs. {{ number_format($order->advance_paid) }}</span></div>
                    <div class="flex justify-between pt-2 border-t border-black/5"><span
                            class="font-medium">Remaining</span><span
                            class="font-mono font-bold text-[var(--color-terracotta)]">Rs.
                            {{ number_format($order->remainingAmount()) }}</span></div>
                </div>

                @if ($order->invoice)
                    @if (Route::has('invoices.show'))
                        <a href="{{ route('invoices.show', $order->invoice) }}"
                            class="mt-4 block text-center px-4 py-2 rounded-lg bg-[var(--color-cloth-dim)] text-sm font-medium hover:bg-black/5">
                            View Invoice #{{ $order->invoice->invoice_number }}
                        </a>
                    @endif
                @else
                    @if (Route::has('invoices.create'))
                        <a href="{{ route('invoices.create', $order) }}"
                            class="mt-4 block text-center px-4 py-2 rounded-lg bg-[var(--color-thread-gold)] text-white text-sm font-semibold hover:opacity-90">
                            Generate Invoice
                        </a>
                    @endif
                @endif
            </div>

            @if ($order->notes)
                <div class="bg-white rounded-xl p-5 shadow-sm ring-1 ring-black/5">
                    <p class="text-xs uppercase tracking-wide text-black/40 mb-2">Notes</p>
                    <p class="text-sm text-black/60">{{ $order->notes }}</p>
                </div>
            @endif
            @if (Route::has('orders.destroy'))
                <form method="POST" action="{{ route('orders.destroy', $order) }}"
                    onsubmit="return confirm('Kya aap sure hain?');">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="w-full text-center px-4 py-2 rounded-lg border border-[var(--color-terracotta)]/30 text-[var(--color-terracotta)] text-sm font-medium hover:bg-[var(--color-terracotta)]/5">
                        Delete Order
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection
