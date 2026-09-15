@extends('layouts.app')
@section('title', 'User Accounts')
@section('subtitle', $users->total() . ' login accounts')

@section('content')
<div class="pt-2 space-y-5">
    <div class="flex justify-end">
        <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)] transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Naya User
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm ring-1 ring-black/5 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs uppercase tracking-wide text-black/40 border-b border-black/5">
                    <th class="px-6 py-3 font-medium">Name</th>
                    <th class="px-6 py-3 font-medium">Email</th>
                    <th class="px-6 py-3 font-medium">Role</th>
                    <th class="px-6 py-3 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-black/5">
                @forelse($users as $user)
                    <tr class="hover:bg-black/[0.02]">
                        <td class="px-6 py-3.5 font-medium">
                            {{ $user->name }}
                            @if($user->id === auth()->id())
                                <span class="ml-1.5 text-[10px] text-black/35 uppercase">(aap)</span>
                            @endif
                        </td>
                        <td class="px-6 py-3.5 text-black/60">{{ $user->email }}</td>
                        <td class="px-6 py-3.5">
                            @php
                                $roleBadge = match($user->role) {
                                    'admin' => 'bg-[var(--color-thread-gold)]/15 text-[var(--color-thread-gold)]',
                                    'manager' => 'bg-[var(--color-thread-teal)]/10 text-[var(--color-thread-teal)]',
                                    default => 'bg-black/5 text-black/50',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $roleBadge }}">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td class="px-6 py-3.5 text-right space-x-3">
                            <a href="{{ route('users.edit', $user) }}" class="text-xs font-medium text-[var(--color-thread-teal)] hover:underline">Edit</a>
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Ye account delete karain?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-[var(--color-terracotta)] hover:underline">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-10 text-center text-black/40">Koi user account nahi mila.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $users->links() }}</div>
</div>
@endsection
