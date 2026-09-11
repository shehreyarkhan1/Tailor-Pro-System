@extends('layouts.app')
@section('title', 'Karigar Edit Karain')

@section('content')
    <div class="pt-2 max-w-xl">
        <div class="bg-white rounded-xl p-6 sm:p-8 shadow-sm ring-1 ring-black/5">
            <form method="POST" action="{{ route('staff.update', $staff) }}" class="space-y-5">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium mb-1.5">Name</label>
                    <input type="text" name="name" value="{{ old('name', $staff->name) }}" required
                        class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $staff->phone) }}"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Role</label>
                    <select name="role"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm">
                        @foreach (['master_tailor' => 'Master Tailor (Ustad)', 'cutter' => 'Cutter', 'stitcher' => 'Stitcher', 'finisher' => 'Finisher', 'manager' => 'Manager'] as $val => $label)
                            <option value="{{ $val }}" @selected(old('role', $staff->role) === $val)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1.5">Monthly Salary (Rs.)</label>
                    <input type="number" name="monthly_salary" value="{{ old('monthly_salary', $staff->monthly_salary) }}"
                        step="0.01"
                        class="w-full px-3.5 py-2.5 rounded-lg border border-black/10 focus:outline-none focus:ring-2 focus:ring-[var(--color-thread-teal)] text-sm font-mono">
                </div>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $staff->is_active))
                        class="rounded border-black/20">
                    Active
                </label>

                <!-- Ab sirf Update aur Cancel isi form ke andar hain -->
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-[var(--color-thread-teal)] text-white text-sm font-semibold hover:bg-[var(--color-thread-teal-dark)]">Update</button>
                    <a href="{{ route('staff.index') }}"
                        class="px-5 py-2.5 rounded-lg border border-black/10 text-sm font-medium hover:bg-black/5">Cancel</a>
                </div>
            </form>

            <!-- Delete form ab bahar, alag/sibling form hai -->
            <div class="flex justify-end mt-3">
                <form method="POST" action="{{ route('staff.destroy', $staff) }}" onsubmit="return confirm('Sure?');">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg border border-[var(--color-terracotta)]/30 text-[var(--color-terracotta)] text-sm font-medium hover:bg-[var(--color-terracotta)]/5">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
