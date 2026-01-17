<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::first();
        
        // Jika belum ada data, buat data kosong
        if (!$pengaturan) {
            $pengaturan = Pengaturan::create([]);
        }
        
        return view('admin.pengaturan.index', compact('pengaturan'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'nullable|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024'
        ]);

        $pengaturan = Pengaturan::first();
        
        if (!$pengaturan) {
            $pengaturan = new Pengaturan();
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($pengaturan->logo && Storage::disk('public')->exists($pengaturan->logo)) {
                Storage::disk('public')->delete($pengaturan->logo);
            }
            
            $logoPath = $request->file('logo')->store('logo', 'public');
            $validated['logo'] = $logoPath;
        }

        // Handle favicon upload
        if ($request->hasFile('favicon')) {
            // Hapus favicon lama jika ada
            if ($pengaturan->favicon && Storage::disk('public')->exists($pengaturan->favicon)) {
                Storage::disk('public')->delete($pengaturan->favicon);
            }
            
            $faviconPath = $request->file('favicon')->store('logo', 'public');
            $validated['favicon'] = $faviconPath;
        }

        // Update atau create data
        if ($pengaturan->exists) {
            $pengaturan->update($validated);
        } else {
            $pengaturan->fill($validated);
            $pengaturan->save();
        }

        return redirect()->route('admin.pengaturan.index')
            ->with('success', 'Pengaturan berhasil diperbarui');
    }
}