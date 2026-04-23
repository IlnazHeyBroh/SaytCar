<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::withCount('bbs')->latest()->paginate(12),
        ]);
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user->loadCount('bbs'),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'is_admin' => 'nullable|boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->is_admin = $request->boolean('is_admin');

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if ($user->id === $request->user()->id) {
            $user->is_admin = true;
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Пользователь обновлён.');
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return back()->with('success', 'Свой аккаунт через админку удалить нельзя.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Пользователь удалён.');
    }
}
