@extends('layouts.app')
@section('title', 'Style Categories')
@section('subtitle', 'Collar, cuff, patti wagera ke options manage karain')

@section('content')
<div class="pt-2 space-y-5">
    <div class="flex justify-end">
        <a href="{{ route('style-categories.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)] transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Nayi Category
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($categories as $category)
            <a href="{{ route('style-categories.edit', $category) }}" class="bg-white rounded-xl p-5 shadow-sm ring-1 ring-black/5 hover:ring-[var(--color-thread-teal)]/30 hover:shadow-md transition-all">
                <div class="flex items-start justify-between mb-2">
                    <p class="font-semibold text-sm">{{ $category->name }}</p>
                    @if(!$category->is_active)
                        <span class="px-2 py-0.5 rounded-full bg-black/5 text-black/40 text-[10px] font-bold uppercase">Inactive</span>
                    @endif
                </div>
                <p class="text-xs text-black/40 font-mono mb-4">{{ $category->code }}</p>
                <div class="flex items-center justify-between pt-3 border-t border-black/5">
                    <span class="text-xs text-black/45">{{ $category->options_count }} options</span>
                    <span class="text-xs font-medium text-[var(--color-thread-teal)]">Manage →</span>
                </div>
            </a>
        @empty
            <div class="col-span-full bg-white rounded-xl p-12 text-center ring-1 ring-black/5 text-black/40">
                Koi category nahi bani abhi tak.
            </div>
        @endforelse
    </div>
</div>
@endsection
