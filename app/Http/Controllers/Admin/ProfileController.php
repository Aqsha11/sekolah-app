<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    /**
     * Form edit profil user yang sedang login
     */
    public function edit(): View
    {
        return view('admin.profile.edit', ['user' => auth()->user()]);
    }

    /**
     * Update nama, email, phone
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string',
        ]);

        auth()->user()->update($validated);

        return redirect()->route('admin.profile.edit')->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Update avatar user
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate(['avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048']);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = auth()->id() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('avatars', $filename, 'public');
            auth()->user()->update(['avatar' => $filename]);
        }

        return back()->with('success', 'Avatar berhasil diubah');
    }

    /**
     * Update password user
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);

        auth()->user()->update(['password' => bcrypt($validated['password'])]);

        return back()->with('success', 'Password berhasil diubah');
    }
}
