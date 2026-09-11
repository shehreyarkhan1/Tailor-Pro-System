@extends('layouts.app')
@section('title', $category->name)
@section('subtitle', $category->options->count() . ' style options')

@section('content')
    <div class="pt-2 space-y-5">

        <!-- Category settings -->
        <div class="bg-white rounded-xl p-6 shadow-sm ring-1 ring-black/5">
            <h3 class="font-display text-lg font-semibold mb-4">Category Settings</h3>
            <form method="POST" action="{{ route('style-categories.update', $category) }}" class="space-y-4">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium mb-1.5">Name</label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}"
                            min="0"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm font-mono">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Code</label>
                        <input type="text" name="code" value="{{ old('code', $category->code) }}" required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm font-mono">
                    </div>
                    <div class="flex items-end">
                        <label class="flex items-center gap-2 text-sm pb-2.5">
                            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active))
                                class="rounded border-black/20">
                            Active (order form mein dikhe)
                        </label>
                    </div>
                </div>
                <div class="flex gap-3 pt-1">
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)]">Update
                        Category</button>

                </div>
            </form>
            <form method="POST" action="{{ route('style-categories.destroy', $category) }}"
                onsubmit="return confirm('Sure? Is category ke sath uske tamam options bhi delete ho jayenge.');">
                @csrf @method('DELETE')
                <button type="submit"
                    class="px-5 py-2.5 rounded-lg border border-[var(--color-terracotta)]/30 text-[var(--color-terracotta)] text-sm font-medium hover:bg-[var(--color-terracotta)]/5">Delete
                    Category</button>
            </form>
        </div>

        <!-- Options list -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-black/5 overflow-hidden">
            <div class="px-6 py-4 border-b border-black/5">
                <h3 class="font-display text-lg font-semibold">Style Options</h3>
            </div>

            <div class="divide-y divide-black/5">
                @forelse($category->options as $option)
                    <div x-data="{ editing: false }" class="px-6 py-4">
                        <!-- Display row -->
                        <div x-show="!editing" class="flex items-center gap-4">
                            <span
                                class="relative w-9 h-9 rounded-full shrink-0 flex items-center justify-center ring-1 ring-black/5"
                                style="background-color: {{ $option->swatch_color ?? '#E5E5E5' }}">
                                @if ($option->icon_path)
                                    <img src="{{ asset('storage/' . $option->icon_path) }}" class="w-5 h-5" alt=""
                                        onerror="this.remove()">
                                @endif
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium">{{ $option->name }} <span
                                        class="text-black/30 font-mono text-xs">({{ $option->code }})</span></p>
                                <p class="text-xs text-black/40">
                                    @if ($option->extra_price > 0)
                                        +Rs. {{ number_format($option->extra_price) }} ·
                                    @endif
                                    {{ $option->description ?? 'Koi description nahi' }}
                                </p>
                            </div>
                            @if (!$option->is_active)
                                <span
                                    class="px-2 py-0.5 rounded-full bg-black/5 text-black/40 text-[10px] font-bold uppercase">Inactive</span>
                            @endif
                            <button @click="editing = true"
                                class="text-xs font-medium text-[var(--color-thread-teal)] hover:underline">Edit</button>
                            <form method="POST" action="{{ route('style-options.destroy', $option) }}"
                                onsubmit="return confirm('Ye option delete karain?');">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="text-xs font-medium text-[var(--color-terracotta)] hover:underline">Delete</button>
                            </form>
                        </div>

                        <!-- Inline edit form -->
                        <form x-show="editing" method="POST" action="{{ route('style-options.update', $option) }}"
                            class="space-y-3" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="grid grid-cols-2 sm:grid-cols-6 gap-3">
                                <div class="col-span-2">
                                    <label class="block text-xs font-medium text-black/50 mb-1">Name</label>
                                    <input type="text" name="name" value="{{ $option->name }}" required
                                        class="w-full px-3 py-2 rounded-lg border border-black/10 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-black/50 mb-1">Code</label>
                                    <input type="text" name="code" value="{{ $option->code }}" required
                                        class="w-full px-3 py-2 rounded-lg border border-black/10 text-sm font-mono">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-black/50 mb-1">Color</label>
                                    <input type="color" name="swatch_color"
                                        value="{{ $option->swatch_color ?? '#0F5C56' }}"
                                        class="w-full h-[38px] px-1 rounded-lg border border-black/10">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-black/50 mb-1">Extra Price</label>
                                    <input type="number" step="0.01" name="extra_price"
                                        value="{{ $option->extra_price }}"
                                        class="w-full px-3 py-2 rounded-lg border border-black/10 text-sm font-mono">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-black/50 mb-1">Sort</label>
                                    <input type="number" name="sort_order" value="{{ $option->sort_order }}"
                                        class="w-full px-3 py-2 rounded-lg border border-black/10 text-sm font-mono">
                                </div>
                                <div class="col-span-2 sm:col-span-3">
                                    <label class="block text-xs font-medium text-black/50 mb-1">Icon</label>
                                    <div class="flex items-center gap-3">
                                        @if ($option->icon_path)
                                            <div x-data="{ removed: false }">
                                                <div x-show="!removed" class="flex items-center gap-2">
                                                    <img src="{{ $option->iconUrl() }}"
                                                        class="w-8 h-8 rounded ring-1 ring-black/10 bg-[var(--color-cloth)] p-1"
                                                        alt="">
                                                    <label
                                                        class="flex items-center gap-1.5 text-xs text-[var(--color-terracotta)] cursor-pointer">
                                                        <input type="checkbox" name="remove_icon" value="1"
                                                            x-model="removed" class="rounded border-black/20">
                                                        Remove
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                        <input type="file" name="icon" accept=".svg,.png,.jpg,.jpeg,.webp"
                                            class="flex-1 text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-[var(--color-thread-teal)]/10 file:text-[var(--color-thread-teal)] hover:file:bg-[var(--color-thread-teal)]/20">
                                    </div>
                                    <p class="text-[11px] text-black/40 mt-1">SVG ya PNG, max 512KB. Khaali chodain agar
                                        change nahi karna.</p>
                                </div>
                                <div class="col-span-2 sm:col-span-3">
                                    <label class="block text-xs font-medium text-black/50 mb-1">Description</label>
                                    <input type="text" name="description" value="{{ $option->description }}"
                                        class="w-full px-3 py-2 rounded-lg border border-black/10 text-sm">
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <label class="flex items-center gap-2 text-xs">
                                    <input type="checkbox" name="is_active" value="1" @checked($option->is_active)
                                        class="rounded border-black/20">
                                    Active
                                </label>
                                <button type="submit"
                                    class="ml-auto px-4 py-1.5 rounded-lg bg-[var(--color-thread-teal)] text-white text-xs font-semibold hover:bg-[var(--color-thread-teal-dark)]">Save</button>
                                <button type="button" @click="editing = false"
                                    class="px-4 py-1.5 rounded-lg border border-black/10 text-xs font-medium hover:bg-black/5">Cancel</button>
                            </div>
                        </form>
                    </div>
                @empty
                    <div class="px-6 py-10 text-center text-black/40">Koi option nahi bana abhi tak.</div>
                @endforelse
            </div>

            <!-- Add new option -->
            <div class="px-6 py-5 bg-[var(--color-cloth)] border-t border-black/5">
                <p class="text-sm font-semibold mb-3">+ Naya Option Add Karain</p>
                <form method="POST" action="{{ route('style-options.store', $category) }}" class="space-y-3">
                    @csrf
                    <div class="grid grid-cols-2 sm:grid-cols-6 gap-3">
                        <div class="col-span-2">
                            <input type="text" name="name" placeholder="Name (e.g. Peshawari Collar)" required
                                class="w-full px-3 py-2 rounded-lg border border-black/10 text-sm">
                        </div>
                        <div>
                            <input type="text" name="code" placeholder="code" required
                                class="w-full px-3 py-2 rounded-lg border border-black/10 text-sm font-mono">
                        </div>
                        <div>
                            <input type="color" name="swatch_color" value="#0F5C56"
                                class="w-full h-[38px] px-1 rounded-lg border border-black/10">
                        </div>
                        <div>
                            <input type="number" step="0.01" name="extra_price" placeholder="Extra Rs."
                                class="w-full px-3 py-2 rounded-lg border border-black/10 text-sm font-mono">
                        </div>
                        <div>
                            <input type="number" name="sort_order" placeholder="Sort"
                                class="w-full px-3 py-2 rounded-lg border border-black/10 text-sm font-mono">
                        </div>
                    </div>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-[var(--color-thread-gold)] text-white text-sm font-semibold hover:opacity-90">Add
                        Option</button>
                </form>
            </div>
        </div>
    </div>
@endsection
