<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return view('admin.profile.show', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();

        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:5120'], // Max 5MB untuk HD
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.max' => 'Nama maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'profile_photo.image' => 'File harus berupa gambar',
            'profile_photo.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'profile_photo.max' => 'Ukuran gambar maksimal 5MB',
        ]);

        // Update nama dan email
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Handle upload foto profil dengan konversi ke WebP
        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo) {
                ImageHelper::delete($user->profile_photo);
            }

            // Upload foto baru dengan konversi WebP untuk ukuran kecil tapi tetap HD
            $path = ImageHelper::uploadProfilePhoto(
                $request->file('profile_photo'),
                'profile-photos',
                500, // Width
                500, // Height (square untuk profile)
                85   // Quality (85% untuk balance antara kualitas dan ukuran)
            );

            $user->profile_photo = $path;
        }

        $user->save();

        return redirect()->route('admin.profile.show')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'current_password.current_password' => 'Password saat ini tidak sesuai',
            'password.required' => 'Password baru wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('admin.profile.show')
            ->with('success', 'Password berhasil diubah!');
    }

    public function deletePhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo) {
            ImageHelper::delete($user->profile_photo);
            $user->profile_photo = null;
            $user->save();

            return redirect()->route('admin.profile.edit')
                ->with('success', 'Foto profil berhasil dihapus!');
        }

        return redirect()->route('admin.profile.edit')
            ->with('error', 'Tidak ada foto profil yang dapat dihapus');
    }
}
