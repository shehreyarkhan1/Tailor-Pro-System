<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(12);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,staff,manager',
        ]);
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User Created Successfully');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|email|max:255', rule::unique('users')->ignore($user->id),
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,staff,manager',
        ]);
        if (! empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);

        } else {
            unset($validated['password']);
        }
        $user->update($validated);

        return redirect()->route('users.index', compact('user'))->with('success', 'User Account Update Successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User Account Deleted');
    }
}
