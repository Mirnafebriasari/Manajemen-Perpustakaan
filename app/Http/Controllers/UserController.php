<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);
        return view('users.show', compact('user'));
    }
    // Form create user
    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
{
        $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
        'role' => 'required|in:admin,pegawai,mahasiswa',
    ];
    if ($request->role === 'mahasiswa') {
        $rules['email'] .= '|regex:/@university\.edu$/'; // Ganti dengan domain universitas Anda, e.g., @student.univ.ac.id
    }
    $request->validate($rules);
    
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
        'role' => 'required|in:admin,pegawai,mahasiswa',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    // Assign role otomatis
    $user->assignRole($request->role);

    return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan.');
}

    // Form edit user
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
    }

    // Hapus user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
