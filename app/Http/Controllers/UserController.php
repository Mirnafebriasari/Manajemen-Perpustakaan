<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); 
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $user = null;
        return view('users.form', compact('user'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.form', compact('user'));

    }

   public function store(Request $request)
{
    $rules = [
        'name' => 'required|string|max:255',
        'email' => ['required', 'email', 'unique:users,email'],
        'role' => 'required|in:admin,pegawai,mahasiswa',
        'password' => 'required|string|min:6|confirmed',
    ];

    if ($request->role === 'mahasiswa') {
        $rules['email'][] = 'regex:/@universitas\.ac\.id$/i';
    }

    $request->validate($rules);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $user->assignRole($request->role);
    return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
}

public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        'role' => 'required|in:admin,pegawai,mahasiswa',
        'current_password' => 'required',
        'password' => 'nullable|string|min:6|confirmed',
    ]);

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors([
            'current_password' => 'Password saat ini tidak sesuai.',
        ])->withInput();
    }

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    $user->save();
    $user->syncRoles([$request->role]);
    return redirect()->route('users.index')->with('success', 'Pengguna berhasil diupdate.');
}

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }

    public function destroyAccount(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();
        return redirect('/')->with('success', 'Akun Anda berhasil dihapus.');
    }
}
