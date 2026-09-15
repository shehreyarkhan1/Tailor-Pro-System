@extends('layouts.app')
@section('title', 'User Edit Karain')

@section('content')
<div class="pt-2 max-w-lg">
    <div class="bg-white rounded-xl p-6 sm:p-8 shadow-sm ring-1 ring-black/5">
        <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium mb-1.5">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">New Password</label>
                <input type="password" name="password" minlength="8"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                <p class="text-xs text-black/40 mt-1">Khaali chodain agar password change nahi karna.</p>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Confirm New Password</label>
                <input type="password" name="password_confirmation" minlength="8"
                       class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1.5">Role</label>
                <select name="role" class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                    @foreach(['staff' => 'Staff', 'manager' => 'Manager', 'admin' => 'Admin'] as $val => $label)
                        <option value="{{ $val }}" @selected(old('role', $user->role) === $val)>{{ $label }}</option>
                    @endforeach
                </select>
                @if($user->id === auth()->id())
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <p class="text-xs text-black/40 mt-1">Aap apna khud ka role change nahi kar sakte.</p>
                @endif
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)]">Update</button>
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 rounded-lg border border-black/10 text-sm font-medium hover:bg-black/5">Cancel</a>
            </div>
        </form>

        @if($user->id !== auth()->id())
            <div class="mt-3">
                <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Sure?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-5 py-2.5 rounded-lg border border-[var(--color-terracotta)]/30 text-[var(--color-terracotta)] text-sm font-medium hover:bg-[var(--color-terracotta)]/5">Delete</button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
