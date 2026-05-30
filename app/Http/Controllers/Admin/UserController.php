<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $users = User::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nama_lengkap', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('role', 'like', "%{$search}%")
                      ->orWhere('prodi', 'like', "%{$search}%")
                      ->orWhere('jurusan', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();
            
        return view('admin.user.index', compact('users', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:tb_user',
            'nomor_telepon' => 'required|string|max:20',
            'role' => ['required', Rule::in(['admin', 'kaprodi'])],
            'prodi' => 'required_if:role,kaprodi|nullable|string|max:255',
            'jurusan' => 'required_if:role,kaprodi|nullable|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'role' => $request->role,
            'prodi' => $request->prodi,
            'jurusan' => $request->jurusan,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('tb_user')->ignore($user->id_user, 'id_user')],
            'nomor_telepon' => 'required|string|max:20',
            'role' => ['required', Rule::in(['admin', 'kaprodi'])],
            'prodi' => 'required_if:role,kaprodi|nullable|string|max:255',
            'jurusan' => 'required_if:role,kaprodi|nullable|string|max:255',
            'password' => 'nullable|string|min:8',
        ]);

        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->nomor_telepon = $request->nomor_telepon;
        $user->role = $request->role;
        $user->prodi = $request->prodi;
        $user->jurusan = $request->jurusan;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id_user === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
