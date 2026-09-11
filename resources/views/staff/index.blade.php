@extends('layouts.app')
@section('title', 'Staff / Karigar')
@section('subtitle', $staff->total() . ' team members')

@section('content')
    <div class="pt-2 space-y-5">
        <div class="flex justify-end">
            <a href="{{ route('staff.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                New Karigar
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @forelse($staff as $s)
                <div class="bg-white rounded-xl p-5 shadow-sm ring-1 ring-black/5">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-11 h-11 rounded-full bg-[var(--color-thread-gold)]/15 text-[var(--color-thread-gold)] flex items-center justify-center font-display font-semibold">
                                {{ strtoupper(substr($s->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-sm">{{ $s->name }}</p>
                                <p class="text-xs text-black/40">{{ $s->roleLabel() }}</p>
                            </div>
                        </div>
                        @if (!$s->is_active)
                            <span
                                class="px-2 py-0.5 rounded-full bg-black/5 text-black/40 text-[10px] font-bold uppercase">Inactive</span>
                        @endif
                    </div>
                    <div class="text-sm text-black/60 space-y-1 mb-4">
                        <p>{{ $s->phone ?? '—' }}</p>
                        @if ($s->monthly_salary)
                            <p class="font-mono text-xs text-black/40">Rs. {{ number_format($s->monthly_salary) }}/month</p>
                        @endif
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-black/5">
                        <span class="text-xs text-black/40">{{ $s->orders_count }} active orders</span>
                        <a href="{{ route('staff.edit', $s) }}"
                            class="text-xs font-medium text-[var(--color-thread-teal)] hover:underline">Edit</a>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-xl p-12 text-center ring-1 ring-black/5 text-black/40">Koi
                    karigar add nahi hua abhi tak.</div>
            @endforelse
        </div>

        <div>{{ $staff->links() }}</div>
    </div>
@endsection
