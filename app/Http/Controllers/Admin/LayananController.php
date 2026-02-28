<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LayananController extends Controller
{
    public function __construct()
    {
        DateHelper::setDefaultTimezone();
    }

    public function index()
    {
        $layanans = Layanan::orderBy('urutan')->get();

        return view('admin.layanan.index', compact('layanans'));
    }

    public function create()
    {
        $nextUrutan = Layanan::max('urutan') + 1;

        return view('admin.layanan.create', compact('nextUrutan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('layanan', 'nama')],
            'deskripsi_singkat' => 'required|string|max:500',
            'deskripsi_lengkap' => 'required|string',
            'icon' => 'required|string|max:100',
            'gambar' => 'required|image|mimes:jpeg,jpg,png,webp|max:10240',
            'fasilitas' => 'required|array|min:1',
            'fasilitas.*' => 'required|string|max:255',
            'unggulan' => 'boolean',
            'aktif' => 'boolean',
        ], [
            'nama.required' => 'Nama layanan wajib diisi',
            'nama.max' => 'Nama layanan maksimal 255 karakter',
            'nama.unique' => 'Nama layanan "'.$request->nama.'" sudah digunakan, silakan gunakan nama lain',
            'deskripsi_singkat.required' => 'Deskripsi singkat wajib diisi',
            'deskripsi_singkat.max' => 'Deskripsi singkat maksimal 500 karakter',
            'deskripsi_lengkap.required' => 'Deskripsi lengkap wajib diisi',
            'icon.required' => 'Icon wajib diisi',
            'icon.max' => 'Icon maksimal 100 karakter',
            'gambar.required' => 'Gambar layanan wajib diupload',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WebP',
            'gambar.max' => 'Ukuran gambar maksimal 10MB',
            'fasilitas.required' => 'Minimal satu fasilitas wajib diisi',
            'fasilitas.min' => 'Minimal satu fasilitas wajib diisi',
            'fasilitas.*.required' => 'Nama fasilitas tidak boleh kosong',
            'fasilitas.*.max' => 'Nama fasilitas maksimal 255 karakter',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);
        $validated['urutan'] = Layanan::max('urutan') + 1;
        $validated['created_at'] = DateHelper::now();
        $validated['updated_at'] = DateHelper::now();

        // Upload gambar (convert ke WebP HD)
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = ImageHelper::uploadHDWebP(
                $request->file('gambar'),
                'layanan',
                1920,
                90
            );
        }

        Layanan::create($validated);

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan pada '.DateHelper::formatDateTimeIndonesia(DateHelper::now()));
    }

    public function show(Layanan $layanan)
    {
        return view('admin.layanan.show', compact('layanan'));
    }

    public function edit(Layanan $layanan)
    {
        $allLayanans = Layanan::orderBy('urutan')->get();
        $maxUrutan = Layanan::max('urutan');

        return view('admin.layanan.edit', compact('layanan', 'allLayanans', 'maxUrutan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('layanan', 'nama')->ignore($layanan->id)],
            'deskripsi_singkat' => 'required|string|max:500',
            'deskripsi_lengkap' => 'required|string',
            'icon' => 'required|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'fasilitas' => 'required|array|min:1',
            'fasilitas.*' => 'required|string|max:255',
            'urutan' => [
                'required',
                'integer',
                'min:1',
                'max:'.Layanan::max('urutan'),
            ],
            'unggulan' => 'boolean',
            'aktif' => 'boolean',
        ], [
            'nama.required' => 'Nama layanan wajib diisi',
            'nama.max' => 'Nama layanan maksimal 255 karakter',
            'nama.unique' => 'Nama layanan "'.$request->nama.'" sudah digunakan, silakan gunakan nama lain',
            'deskripsi_singkat.required' => 'Deskripsi singkat wajib diisi',
            'deskripsi_singkat.max' => 'Deskripsi singkat maksimal 500 karakter',
            'deskripsi_lengkap.required' => 'Deskripsi lengkap wajib diisi',
            'icon.required' => 'Icon wajib diisi',
            'icon.max' => 'Icon maksimal 100 karakter',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WebP',
            'gambar.max' => 'Ukuran gambar maksimal 10MB',
            'fasilitas.required' => 'Minimal satu fasilitas wajib diisi',
            'fasilitas.min' => 'Minimal satu fasilitas wajib diisi',
            'fasilitas.*.required' => 'Nama fasilitas tidak boleh kosong',
            'fasilitas.*.max' => 'Nama fasilitas maksimal 255 karakter',
            'urutan.required' => 'Urutan wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
            'urutan.min' => 'Urutan tidak boleh kurang dari 1',
            'urutan.max' => 'Urutan tidak boleh lebih dari '.Layanan::max('urutan'),
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        // Upload gambar baru (convert ke WebP HD), hapus gambar lama
        if ($request->hasFile('gambar')) {
            if ($layanan->gambar) {
                ImageHelper::delete($layanan->gambar);
            }

            $validated['gambar'] = ImageHelper::uploadHDWebP(
                $request->file('gambar'),
                'layanan',
                1920,
                90
            );
        }

        $urutanLama = $layanan->urutan;
        $urutanBaru = $validated['urutan'];

        if ($urutanLama != $urutanBaru) {
            DB::transaction(function () use ($layanan, $urutanLama, $urutanBaru, $validated) {

                // Langkah 1: Parkir layanan yang diedit ke urutan sementara (negatif)
                DB::statement('UPDATE layanan SET urutan = -1 WHERE id = ?', [$layanan->id]);

                if ($urutanBaru < $urutanLama) {
                    // Pindah ke atas: geser ke bawah semua yang ada di antara urutanBaru s/d urutanLama-1
                    // ORDER BY DESC agar tidak bentrok unique constraint
                    DB::statement('
                        UPDATE layanan
                        SET urutan = urutan + 1
                        WHERE urutan >= ?
                          AND urutan < ?
                        ORDER BY urutan DESC
                    ', [$urutanBaru, $urutanLama]);
                } else {
                    // Pindah ke bawah: geser ke atas semua yang ada di antara urutanLama+1 s/d urutanBaru
                    // ORDER BY ASC agar tidak bentrok unique constraint
                    DB::statement('
                        UPDATE layanan
                        SET urutan = urutan - 1
                        WHERE urutan > ?
                          AND urutan <= ?
                        ORDER BY urutan ASC
                    ', [$urutanLama, $urutanBaru]);
                }

                // Langkah 3: Pindahkan layanan ke urutan tujuan yang sudah kosong
                $validated['updated_at'] = DateHelper::now();
                $validated['urutan'] = $urutanBaru;
                $layanan->fill($validated);
                $layanan->save();
            });
        } else {
            $validated['updated_at'] = DateHelper::now();
            $layanan->update($validated);
        }

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil diupdate pada '.DateHelper::formatDateTimeIndonesia(DateHelper::now()));
    }

    public function destroy(Layanan $layanan)
    {
        $urutanDihapus = $layanan->urutan;

        DB::transaction(function () use ($layanan, $urutanDihapus) {
            // Hapus gambar dari storage
            if ($layanan->gambar) {
                ImageHelper::delete($layanan->gambar);
            }

            $layanan->delete();

            // Rapikan urutan: semua di bawahnya naik satu
            // ORDER BY ASC agar decrement tidak bentrok unique constraint
            DB::statement('
                UPDATE layanan
                SET urutan = urutan - 1
                WHERE urutan > ?
                ORDER BY urutan ASC
            ', [$urutanDihapus]);
        });

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus pada '.DateHelper::formatDateTimeIndonesia(DateHelper::now()));
    }
}
