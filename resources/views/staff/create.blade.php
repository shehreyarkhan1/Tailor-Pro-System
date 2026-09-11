@extends('layouts.app')
@section('title', 'New Karigar')

@section('content')
<div class="pt-2 max-w-xl">
    <div class="bg-white rounded-xl p-6 sm:p-8 shadow-sm ring-1 ring-black/5">
        <form method="POST" action="{{ route('staff.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1.5">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Role</label>
                <select name="role" class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                    <option value="master_tailor">Master Tailor (Ustad)</option>
                    <option value="cutter">Cutter</option>
                    <option value="stitcher">Stitcher</option>
                    <option value="finisher">Finisher</option>
                    <option value="manager">Manager</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Monthly Salary (Rs.)</label>
                <input type="number" name="monthly_salary" value="{{ old('monthly_salary') }}" step="0.01"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm font-mono">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)]">Save</button>
                <a href="{{ route('staff.index') }}" class="px-5 py-2.5 rounded-lg border border-black/10 text-sm font-medium hover:bg-black/5">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
