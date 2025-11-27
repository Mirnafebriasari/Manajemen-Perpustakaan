<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
public function edit(Request $request)
{
    return view('profile.edit', [
        'user' => $request->user(),  // pastikan ini sudah ada
    ]);
}


    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'current_password' => 'required',
    ]);

    // Cek apakah password saat ini benar
    if (! Hash::check($request->current_password, auth()->user()->password)) {
        return back()->withErrors([
            'current_password' => 'Password saat ini tidak sesuai.',
        ]);
    }

    // Update
    $user = auth()->user();
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    return back()->with('status', 'Profil berhasil diperbarui.');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function showChangePasswordForm()
{
    return view('profile.change-password');
}

public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => ['required', 'current_password'],  // Laravel 8+ built-in rule
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    $user = auth()->user();
    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()->route('profile.edit')->with('success', 'Password berhasil diubah.');
}

}
