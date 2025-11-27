<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Tampilkan daftar user
    public function index()
    {
        $users = User::all(); // bisa ditambah paginate
        return view('users.index', compact('users'));
    }

    // Form tambah user
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

    // Jika role mahasiswa, batasi email harus domain universitas.ac.id
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
    $rules = [
        'name' => 'required|string|max:255',
        'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        'role' => 'required|in:admin,pegawai,mahasiswa',
        'password' => 'nullable|string|min:6|confirmed',
    ];

    if ($request->role === 'mahasiswa') {
        $rules['email'][] = 'regex:/@universitas\.ac\.id$/i';
    }

    $request->validate($rules);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    $user->syncRoles([$request->role]);

    return redirect()->route('users.index')->with('success', 'Pengguna berhasil diupdate.');
}

    // Hapus user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
