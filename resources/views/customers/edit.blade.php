@extends('layouts.app')
@section('title', 'Customer Edit')

@section('content')
<div class="pt-2 max-w-2xl">
    <div class="bg-white rounded-xl p-6 sm:p-8 shadow-sm ring-1 ring-black/5">
        <form method="POST" action="{{ route('customers.update', $customer) }}" class="space-y-5">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1.5">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $customer->name) }}" required
                           class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" required
                           class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $customer->whatsapp) }}"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Gender</label>
                    <select name="gender" class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                        @foreach(['male' => 'Male', 'female' => 'Female', 'kids' => 'Kids'] as $val => $label)
                            <option value="{{ $val }}" @selected(old('gender', $customer->gender) === $val)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">City</label>
                    <input type="text" name="city" value="{{ old('city', $customer->city) }}"
                           class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1.5">Address</label>
                    <textarea name="address" rows="2" class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">{{ old('address', $customer->address) }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium mb-1.5">Notes</label>
                    <textarea name="notes" rows="2" class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">{{ old('notes', $customer->notes) }}</textarea>
                </div>
                <div class="sm:col-span-2">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="is_vip" value="1" @checked(old('is_vip', $customer->is_vip)) class="rounded border-black/20">
                        VIP Customer
                    </label>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)] transition-colors">Update</button>
                <a href="{{ route('customers.show', $customer) }}" class="px-5 py-2.5 rounded-lg border border-black/10 text-sm font-medium hover:bg-black/5 transition-colors">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
