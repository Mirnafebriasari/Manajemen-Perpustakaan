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
    public function edit(Request $request)
    {
    return view('profile.edit', [
        'user' => $request->user(),
     ]);
 }


    public function update(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'current_password' => 'required',
    ]);

    if (! Hash::check($request->current_password, auth()->user()->password)) {
        return back()->withErrors([
            'current_password' => 'Password saat ini tidak sesuai.',
        ]);
    }

    $user = auth()->user();
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    return back()->with('status', 'Profil berhasil diperbarui.');
    }

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
        'current_password' => ['required', 'current_password'], 
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    $user = auth()->user();
    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()->route('profile.edit')->with('success', 'Password berhasil diubah.');
    }

}
