@extends('layouts.app')
@section('title', 'Dashboard')
@section('subtitle', 'Today\'s Summary — ' . now()->format('l, d M Y'))

@section('content')
<div class="space-y-6 pt-2">

    <!-- Stat cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        @php
            $stats = [
                ['label' => 'Total Customers', 'value' => $totalCustomers, 'icon' => 'M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4', 'accent' => 'thread-teal'],
                ['label' => 'Active Orders', 'value' => $activeOrders, 'icon' => 'M9 2a1 1 0 00-1 1v1H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2V3a1 1 0 00-1-1H9zM8 11h8M8 15h5', 'accent' => 'thread-gold'],
                ['label' => 'Ready for Delivery', 'value' => $readyForDelivery, 'icon' => 'M5 13l4 4L19 7', 'accent' => 'leaf'],
                ['label' => 'Overdue Orders', 'value' => $overdueOrders, 'icon' => 'M12 9v3.75m0 3.75h.008v.008H12v-.008zM21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'accent' => 'terracotta'],
            ];
        @endphp

        @foreach ($stats as $s)
            <div class="relative bg-white rounded-xl p-5 shadow-sm ring-1 ring-black/5 overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1 bg-[var(--color-{{ $s['accent'] }})]"></div>
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-black/45 uppercase tracking-wide">{{ $s['label'] }}</p>
                        <p class="font-display text-3xl font-semibold mt-1.5 text-[var(--color-ink)]">{{ $s['value'] }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-[var(--color-{{ $s['accent'] }})]/10 flex items-center justify-center text-[var(--color-{{ $s['accent'] }})]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}" />
                        </svg>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Revenue + status breakdown -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
            <div class="flex items-center justify-between mb-1">
                <h3 class="font-display text-lg font-semibold">Revenue — Last 7 Days</h3>
                <span class="font-mono text-sm text-black/40">Rs. {{ number_format($monthlyRevenue) }} <span class="text-black/30">this month</span></span>
            </div>
            <div class="text-[var(--color-thread-teal)] stitch-line w-10 mb-4"></div>
            <canvas id="revenueChart" height="90"></canvas>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
            <h3 class="font-display text-lg font-semibold mb-1">Order Pipeline</h3>
            <div class="text-[var(--color-thread-gold)] stitch-line w-10 mb-4"></div>
            <div class="space-y-3">
                @php
                    $pipeline = ['pending' => 'Pending', 'cutting' => 'Cutting', 'stitching' => 'Stitching', 'finishing' => 'Finishing', 'ready' => 'Ready', 'delivered' => 'Delivered'];
                    $max = max($statusCounts->max() ?? 1, 1);
                @endphp
                @foreach ($pipeline as $key => $label)
                    @php $count = $statusCounts[$key] ?? 0; @endphp
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-medium text-black/60">{{ $label }}</span>
                            <span class="font-mono text-black/40">{{ $count }}</span>
                        </div>
                        <div class="h-1.5 bg-black/5 rounded-full overflow-hidden">
                            <div class="h-full bg-[var(--color-thread-teal)] rounded-full" style="width: {{ $max ? ($count / $max * 100) : 0 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-5 pt-4 border-t border-black/5 flex items-center justify-between">
                <span class="text-xs text-black/45">Pending Payments</span>
                <span class="font-mono font-semibold text-[var(--color-terracotta)]">Rs. {{ number_format($pendingPayments) }}</span>
            </div>
        </div>
    </div>

    <!-- Recent orders -->
    <div class="bg-white rounded-xl shadow-sm ring-1 ring-black/5 overflow-hidden">
        <div class="px-6 py-4 flex items-center justify-between border-b border-black/5">
            <h3 class="font-display text-lg font-semibold">Recent Orders</h3>
            @if (Route::has('orders.index'))
                <a href="{{ route('orders.index') }}" class="text-sm font-medium text-[var(--color-thread-teal)] hover:underline">Sab dekhain →</a>
            @endif
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wide text-black/40 border-b border-black/5">
                        <th class="px-6 py-3 font-medium">Order #</th>
                        <th class="px-6 py-3 font-medium">Customer</th>
                        <th class="px-6 py-3 font-medium">Delivery</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                        <th class="px-6 py-3 font-medium text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5">
                    @forelse ($recentOrders as $order)
                        <tr class="hover:bg-black/[0.02] cursor-pointer" onclick="window.location='{{ route('orders.show', $order) }}'">
                            <td class="px-6 py-3.5 font-mono text-xs text-black/60">{{ $order->order_number }}</td>
                            <td class="px-6 py-3.5 font-medium">{{ $order->customer->name }}</td>
                            <td class="px-6 py-3.5 text-black/60">{{ $order->delivery_date->format('d M Y') }}</td>
                            <td class="px-6 py-3.5">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium ring-1 {{ $order->statusColor() }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5 text-right font-mono">Rs. {{ number_format($order->total_amount) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-10 text-center text-black/40">Abhi tak koi order nahi hai.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('revenueChart');
    const labels = {!! json_encode($last7DaysRevenue->pluck('day')->map(fn($d) => \Carbon\Carbon::parse($d)->format('D'))) !!};
    const data = {!! json_encode($last7DaysRevenue->pluck('total')) !!};

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels.length ? labels : ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
            datasets: [{
                label: 'Revenue',
                data: data.length ? data : [0,0,0,0,0,0,0],
                borderColor: '#0F5C56',
                backgroundColor: 'rgba(15,92,86,0.08)',
                fill: true,
                tension: 0.35,
                pointRadius: 3,
                pointBackgroundColor: '#C08829',
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection
