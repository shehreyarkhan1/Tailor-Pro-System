@extends('layouts.app')
@section('title', 'Naya Order')

@section('content')
    <div class="pt-2 max-w-3xl" x-data="{
        items: [{ item_name: 'Shalwar Qameez', fabric_style: '', quantity: 1, unit_price: 2500 }],
        addItem() { this.items.push({ item_name: '', fabric_style: '', quantity: 1, unit_price: 0 }) },
        removeItem(i) { if (this.items.length > 1) this.items.splice(i, 1) },
        total() { return this.items.reduce((sum, it) => sum + (parseFloat(it.quantity || 0) * parseFloat(it.unit_price || 0)), 0) }
    }">
        <form method="POST" action="{{ route('orders.store') }}" class="space-y-5">
            @csrf

            <div class="bg-white rounded-xl p-6 sm:p-8 shadow-sm ring-1 ring-black/5 space-y-5">
                <h3 class="font-display text-lg font-semibold">Order Details</h3>
                <div class="text-[var(--color-thread-teal)] stitch-line w-10"></div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium mb-1.5">Customer</label>
                        <select name="customer_id" required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                            <option value="">— Select Customer —</option>
                            @foreach ($customers as $c)
                                <option value="{{ $c->id }}" @selected($selectedCustomer && $selectedCustomer->id === $c->id)>{{ $c->name }}
                                    ({{ $c->customer_code }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if ($selectedCustomer && $selectedCustomer->measurements->count())
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium mb-1.5">Use Existing Measurement</label>
                            <select name="measurement_id"
                                class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                                <option value="">— None —</option>
                                @foreach ($selectedCustomer->measurements as $m)
                                    <option value="{{ $m->id }}">
                                        {{ str_replace('_', ' ', ucfirst($m->garment_type)) }} —
                                        {{ $m->created_at->format('d M Y') }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium mb-1.5">Order Date</label>
                        <input type="date" name="order_date" value="{{ old('order_date', now()->format('Y-m-d')) }}"
                            required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Delivery Date</label>
                        <input type="date" name="delivery_date"
                            value="{{ old('delivery_date', now()->addDays(5)->format('Y-m-d')) }}" required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Priority</label>
                        <select name="priority"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                            <option value="normal">Normal</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Assign Karigar</label>
                        <select name="assigned_staff_id"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                            <option value="">— Baad mein assign karain —</option>
                            @foreach ($staff as $s)
                                <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->roleLabel() }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 sm:p-8 shadow-sm ring-1 ring-black/5 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="font-display text-lg font-semibold">Order Items</h3>
                    <button type="button" @click="addItem()"
                        class="text-sm font-medium text-[var(--color-thread-teal)] hover:underline">+ Item add
                        karain</button>
                </div>
                <div class="text-[var(--color-thread-gold)] stitch-line w-10"></div>

                <template x-for="(item, i) in items" :key="i">
                    <div class="grid grid-cols-12 gap-3 items-end p-4 rounded-lg bg-[var(--color-cloth)]">
                        <div class="col-span-12 sm:col-span-4">
                            <label class="block text-xs font-medium text-black/50 mb-1">Item Name</label>
                            <input type="text" :name="`items[${i}][item_name]`" x-model="item.item_name" required
                                placeholder="e.g. Qameez, Waistcoat"
                                class="w-full px-3 py-2 rounded-lg border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)]">
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label class="block text-xs font-medium text-black/50 mb-1">Fabric</label>
                            <input type="text" :name="`items[${i}][fabric_style]`" x-model="item.fabric_style"
                                placeholder="Wash n Wear"
                                class="w-full px-3 py-2 rounded-lg border border-black/10 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)]">
                        </div>
                        <div class="col-span-3 sm:col-span-2">
                            <label class="block text-xs font-medium text-black/50 mb-1">Qty</label>
                            <input type="number" :name="`items[${i}][quantity]`" x-model="item.quantity" min="1"
                                required
                                class="w-full px-3 py-2 rounded-lg border border-black/10 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)]">
                        </div>
                        <div class="col-span-3 sm:col-span-2">
                            <label class="block text-xs font-medium text-black/50 mb-1">Price</label>
                            <input type="number" :name="`items[${i}][unit_price]`" x-model="item.unit_price" min="0"
                                step="0.01" required
                                class="w-full px-3 py-2 rounded-lg border border-black/10 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)]">
                        </div>
                        <div class="col-span-12 sm:col-span-1 flex justify-end">
                            <button type="button" @click="removeItem(i)"
                                class="p-2 rounded-lg text-[var(--color-terracotta)] hover:bg-[var(--color-terracotta)]/10">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>

                <div class="flex justify-end pt-2 border-t border-black/5">
                    <div class="text-right">
                        <p class="text-xs text-black/40 uppercase tracking-wide">Grand Total</p>
                        <p class="font-display text-2xl font-semibold" x-text="'Rs. ' + total().toLocaleString()"></p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-6 sm:p-8 shadow-sm ring-1 ring-black/5 space-y-6">
                <h3 class="font-display text-lg font-semibold">Style Selection</h3>
                <div class="text-[var(--color-thread-teal)] stitch-line w-10"></div>

                @foreach ($styleCategories as $category)
                    @if ($category->activeOptions->isNotEmpty())
                        <div>
                            <label class="block text-sm font-medium mb-3">{{ $category->name }}</label>
                            <div class="flex flex-wrap gap-3">
                                @foreach ($category->activeOptions as $option)
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="style_selections[{{ $category->id }}]"
                                            value="{{ $option->id }}" class="sr-only peer"
                                            {{ $loop->first ? 'checked' : '' }}>
                                        <div
                                            class="flex items-center gap-2.5 pl-2.5 pr-4 py-2 rounded-xl border-2 border-black/10 peer-checked:border-[var(--color-thread-teal)] peer-checked:bg-[var(--color-thread-teal)]/5 group-hover:border-black/25 transition-colors">
                                            <!-- Icon if available, swatch color as fallback -->
                                            <span
                                                class="relative w-7 h-7 rounded-full shrink-0 flex items-center justify-center ring-1 ring-black/5"
                                                style="background-color: {{ $option->swatch_color ?? '#E5E5E5' }}">
                                                @if ($option->icon_path)
                                                    <img src="{{ asset('storage/' . $option->icon_path) }}"
                                                        class="w-4 h-4" alt="" onerror="this.remove()">
                                                @endif
                                            </span>
                                            <span>
                                                <span
                                                    class="block text-sm font-medium leading-tight">{{ $option->name }}</span>
                                                @if ($option->extra_price > 0)
                                                    <span
                                                        class="block text-xs text-[var(--color-thread-gold)] font-mono">+Rs.
                                                        {{ number_format($option->extra_price) }}</span>
                                                @endif
                                            </span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="bg-white rounded-xl p-6 sm:p-8 shadow-sm ring-1 ring-black/5 space-y-5">
                <h3 class="font-display text-lg font-semibold">Payment & Notes</h3>
                <div class="text-[var(--color-leaf)] stitch-line w-10"></div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Advance Paid (Rs.)</label>
                        <input type="number" name="advance_paid" value="0" min="0" step="0.01"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm font-mono">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium mb-1.5">Notes</label>
                        <textarea name="notes" rows="2"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm"></textarea>
                    </div>
                </div>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="px-6 py-2.5 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)] transition-colors">Create
                    Order</button>
                <a href="{{ route('orders.index') }}"
                    class="px-6 py-2.5 rounded-lg border border-black/10 text-sm font-medium hover:bg-black/5 transition-colors">Cancel</a>
            </div>
        </form>
    </div>
@endsection
