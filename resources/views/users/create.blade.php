@extends('layouts.app')
@section('title', 'Naya User Account')

@section('content')
<div class="pt-2 max-w-lg">
    <div class="bg-white rounded-xl p-6 sm:p-8 shadow-sm ring-1 ring-black/5">
        <form method="POST" action="{{ route('users.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-1.5">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Password</label>
                <input type="password" name="password" required minlength="8"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                <p class="text-xs text-black/40 mt-1">Kam se kam 8 characters.</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Confirm Password</label>
                <input type="password" name="password_confirmation" required minlength="8"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Role</label>
                <select name="role" class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                    <option value="staff">Staff</option>
                    <option value="manager">Manager</option>
                    <option value="admin">Admin</option>
                </select>
                <p class="text-xs text-black/40 mt-1">Admin: sab kuch manage kar sakta hai. Manager/Staff: normal access.</p>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)]">Create Account</button>
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 rounded-lg border border-black/10 text-sm font-medium hover:bg-black/5">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
