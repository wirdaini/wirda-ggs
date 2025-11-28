<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataUser = User::paginate(10);
        return view('admin.user.index', compact('dataUser'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi dengan rules yang diminta
        $validated = $request->validate([
            'name'            => 'required|string|max:100',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // ✅ TAMBAH VALIDASI
        ], [
            'name.required'         => 'Nama harus diisi',
            'name.max'              => 'Nama maksimal 100 karakter',
            'email.required'        => 'Email harus diisi',
            'email.email'           => 'Format email tidak valid',
            'email.unique'          => 'Email sudah digunakan',
            'password.required'     => 'Password harus diisi',
            'password.min'          => 'Password minimal 8 karakter',
            'password.confirmed'    => 'Konfirmasi password tidak cocok',
            'profile_picture.image' => 'File harus berupa gambar', // ✅ TAMBAH PESAN ERROR
            'profile_picture.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'profile_picture.max'   => 'Ukuran gambar maksimal 2MB',
        ]);

        try {
            $data             = $validated;
            $data['password'] = Hash::make($request->password);

            // ✅ HANDLE PROFILE PICTURE UPLOAD
            if ($request->hasFile('profile_picture')) {
                $profilePicturePath      = $request->file('profile_picture')->store('profile_pictures', 'public');
                $data['profile_picture'] = $profilePicturePath;
            }

            User::create($data);

            return redirect()->route('user.index')->with('success', 'Data user berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->route('user.create')
                ->with('error', 'Gagal menambahkan data user: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $dataUser = User::findOrFail($id);
        return view('admin.user.edit', compact('dataUser'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi dengan rules yang diminta
        $validated = $request->validate([
            'name'            => 'required|string|max:100',
            'email'           => 'required|email|unique:users,email,' . $id,
            'password'        => 'sometimes|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // ✅ TAMBAH VALIDASI
        ], [
            'name.required'         => 'Nama harus diisi',
            'name.max'              => 'Nama maksimal 100 karakter',
            'email.required'        => 'Email harus diisi',
            'email.email'           => 'Format email tidak valid',
            'email.unique'          => 'Email sudah digunakan',
            'password.min'          => 'Password minimal 8 karakter',
            'password.confirmed'    => 'Konfirmasi password tidak cocok',
            'profile_picture.image' => 'File harus berupa gambar',
            'profile_picture.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'profile_picture.max'   => 'Ukuran gambar maksimal 2MB',
        ]);

        try {
            $user = User::findOrFail($id);
            $data = $validated;

            // Jika password diisi, gunakan Hash::make()
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            } else {
                unset($data['password']);
            }

            // ✅ HANDLE PROFILE PICTURE UPLOAD
            if ($request->hasFile('profile_picture')) {
                // Delete old picture if exists
                if ($user->profile_picture) {
                    Storage::disk('public')->delete($user->profile_picture);
                }

                $profilePicturePath      = $request->file('profile_picture')->store('profile_pictures', 'public');
                $data['profile_picture'] = $profilePicturePath;
            }

            $user->update($data);

            return redirect()->route('user.index')->with('success', 'Data user berhasil diupdate!');

        } catch (\Exception $e) {
            return redirect()->route('user.edit', $id)
                ->with('error', 'Gagal mengupdate data user: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('user.index')->with('success', 'Data user berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->route('user.index')->with('error', 'Gagal menghapus data user: ' . $e->getMessage());
        }
    }
}
