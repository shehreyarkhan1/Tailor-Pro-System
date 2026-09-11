@extends('layouts.app')
@section('title', 'Nayi Style Category')

@section('content')
<div class="pt-2 max-w-lg">
    <div class="bg-white rounded-xl p-6 sm:p-8 shadow-sm ring-1 ring-black/5">
        <form method="POST" action="{{ route('style-categories.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1.5">Category Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Collar (Gala)"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Code</label>
                <input type="text" name="code" value="{{ old('code') }}" required placeholder="e.g. collar (unique, lowercase, no space)"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm font-mono">
                <p class="text-xs text-black/40 mt-1">Sirf lowercase letters, numbers aur underscore/dash. Ye system internally use karta hai.</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm font-mono">
                <p class="text-xs text-black/40 mt-1">Chota number pehle dikhta hai order form mein.</p>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)]">Save</button>
                <a href="{{ route('style-categories.index') }}" class="px-5 py-2.5 rounded-lg border border-black/10 text-sm font-medium hover:bg-black/5">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
