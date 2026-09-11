@extends('layouts.app')
@section('title', 'New Customer')

@section('content')
    <div class="pt-2 max-w-2xl">
        <div class="bg-white rounded-xl p-6 sm:p-8 shadow-sm ring-1 ring-black/5">
            @if (Route::has('customers.store'))
            <form method="POST" action="{{ route('customers.store') }}" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium mb-1.5">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="0300-1234567"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">WhatsApp (optional)</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp') }}"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">Gender</label>
                        <select name="gender"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="kids">Kids</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1.5">City</label>
                        <input type="text" name="city" value="{{ old('city', 'Peshawar') }}"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium mb-1.5">Address</label>
                        <textarea name="address" rows="2"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">{{ old('address') }}</textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium mb-1.5">Notes</label>
                        <textarea name="notes" rows="2" placeholder="Koi khaas pasand ya observation..."
                            class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">{{ old('notes') }}</textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="checkbox" name="is_vip" value="1" class="rounded border-black/20">
                            mark VIP Customer
                        </label>
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)] transition-colors">Save
                        Customer</button>
                    <a href="{{ route('customers.index') }}"
                        class="px-5 py-2.5 rounded-lg border border-black/10 text-sm font-medium hover:bg-black/5 transition-colors">Cancel</a>
                </div>
            </form>
            @endif
        </div>
    </div>
@endsection
