<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Armada;
use App\Models\KategoriBus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArmadaController extends Controller
{
    public function __construct()
    {
        DateHelper::setDefaultTimezone();
    }

    public function index()
    {
        $armadas = Armada::with('kategoriBus')->orderBy('urutan')->get();

        return view('admin.armada.index', compact('armadas'));
    }

    public function create()
    {
        $nextUrutan = (Armada::max('urutan') ?? 0) + 1;
        $kategoriBus = KategoriBus::orderBy('nama_kategori')->get();

        return view('admin.armada.create', compact('nextUrutan', 'kategoriBus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:armada,nama',
            'kategori_bus_id' => 'required|exists:kategori_bus,id',
            'deskripsi' => 'nullable|string',
            'gambar_utama' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'galeri.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:100',
            'unggulan' => 'boolean',
            'tersedia' => 'boolean',
        ], [
            'nama.required' => 'Nama armada wajib diisi.',
            'nama.unique' => 'Nama armada sudah digunakan, gunakan nama yang berbeda.',
            'nama.max' => 'Nama armada tidak boleh lebih dari 255 karakter.',
            'kategori_bus_id.required' => 'Tipe bus wajib dipilih.',
            'kategori_bus_id.exists' => 'Tipe bus yang dipilih tidak valid.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'gambar_utama.image' => 'File gambar utama harus berupa gambar.',
            'gambar_utama.mimes' => 'Format gambar utama harus JPG, PNG, atau WebP.',
            'gambar_utama.max' => 'Ukuran gambar utama tidak boleh lebih dari 10MB.',
            'galeri.*.image' => 'Semua file galeri harus berupa gambar.',
            'galeri.*.mimes' => 'Format gambar galeri harus JPG, PNG, atau WebP.',
            'galeri.*.max' => 'Ukuran setiap gambar galeri tidak boleh lebih dari 10MB.',
            'fasilitas.array' => 'Data fasilitas tidak valid.',
            'fasilitas.*.string' => 'Setiap fasilitas harus berupa teks.',
            'fasilitas.*.max' => 'Nama fasilitas tidak boleh lebih dari 100 karakter.',
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['nama']);
        $validated['urutan'] = (Armada::max('urutan') ?? 0) + 1;

        if ($request->hasFile('gambar_utama')) {
            $validated['gambar_utama'] = ImageHelper::uploadHDWebP(
                $request->file('gambar_utama'), 'armada', 1920, 90
            );
        }

        $galeriPaths = [];
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $galeriFile) {
                $galeriPaths[] = ImageHelper::uploadHDWebP(
                    $galeriFile, 'armada/galeri', 1920, 90
                );
            }
        }
        $validated['galeri'] = $galeriPaths;

        // Bersihkan fasilitas kosong
        if (! empty($validated['fasilitas'])) {
            $validated['fasilitas'] = array_values(
                array_filter($validated['fasilitas'], fn ($f) => ! empty(trim($f)))
            );
        }

        $armada = Armada::create($validated);

        return redirect()->route('admin.armada.index')
            ->with('success', 'Armada "'.$armada->nama.'" berhasil ditambahkan ke urutan '.$armada->urutan.'.');
    }

    public function show(Armada $armada)
    {
        $armada->load('kategoriBus');

        return view('admin.armada.show', compact('armada'));
    }

    public function edit(Armada $armada)
    {
        $allArmadas = Armada::orderBy('urutan')->get();
        $maxUrutan = Armada::max('urutan') ?? 1;
        $kategoriBus = KategoriBus::orderBy('nama_kategori')->get();

        return view('admin.armada.edit', compact('armada', 'allArmadas', 'maxUrutan', 'kategoriBus'));
    }

    public function update(Request $request, Armada $armada)
    {
        $maxUrutan = Armada::max('urutan') ?? 1;

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:armada,nama,'.$armada->id,
            'kategori_bus_id' => 'required|exists:kategori_bus,id',
            'deskripsi' => 'nullable|string',
            'gambar_utama' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'galeri.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:100',
            'urutan' => ['required', 'integer', 'min:1', 'max:'.$maxUrutan],
            'unggulan' => 'boolean',
            'tersedia' => 'boolean',
        ], [
            'nama.required' => 'Nama armada wajib diisi.',
            'nama.unique' => 'Nama armada sudah digunakan, gunakan nama yang berbeda.',
            'nama.max' => 'Nama armada tidak boleh lebih dari 255 karakter.',
            'kategori_bus_id.required' => 'Tipe bus wajib dipilih.',
            'kategori_bus_id.exists' => 'Tipe bus yang dipilih tidak valid.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'gambar_utama.image' => 'File gambar utama harus berupa gambar.',
            'gambar_utama.mimes' => 'Format gambar utama harus JPG, PNG, atau WebP.',
            'gambar_utama.max' => 'Ukuran gambar utama tidak boleh lebih dari 10MB.',
            'galeri.*.image' => 'Semua file galeri harus berupa gambar.',
            'galeri.*.mimes' => 'Format gambar galeri harus JPG, PNG, atau WebP.',
            'galeri.*.max' => 'Ukuran setiap gambar galeri tidak boleh lebih dari 10MB.',
            'fasilitas.array' => 'Data fasilitas tidak valid.',
            'fasilitas.*.string' => 'Setiap fasilitas harus berupa teks.',
            'fasilitas.*.max' => 'Nama fasilitas tidak boleh lebih dari 100 karakter.',
            'urutan.required' => 'Urutan tampilan wajib diisi.',
            'urutan.integer' => 'Urutan tampilan harus berupa angka.',
            'urutan.min' => 'Urutan tampilan tidak boleh kurang dari 1.',
            'urutan.max' => 'Urutan tampilan tidak boleh lebih dari '.$maxUrutan.'.',
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['nama'], $armada->id);

        $urutanLama = $armada->urutan;
        $urutanBaru = $validated['urutan'];

        if ($request->hasFile('gambar_utama')) {
            if ($armada->gambar_utama) {
                ImageHelper::delete($armada->gambar_utama);
            }
            $validated['gambar_utama'] = ImageHelper::uploadHDWebP(
                $request->file('gambar_utama'), 'armada', 1920, 90
            );
        }

        $galeriPaths = $armada->galeri ?? [];
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $galeriFile) {
                $galeriPaths[] = ImageHelper::uploadHDWebP(
                    $galeriFile, 'armada/galeri', 1920, 90
                );
            }
        }
        $validated['galeri'] = $galeriPaths;

        // Bersihkan fasilitas kosong
        if (! empty($validated['fasilitas'])) {
            $validated['fasilitas'] = array_values(
                array_filter($validated['fasilitas'], fn ($f) => ! empty(trim($f)))
            );
        }

        if ($urutanLama != $urutanBaru) {
            DB::transaction(function () use ($armada, $urutanLama, $urutanBaru, $validated) {
                DB::statement('UPDATE armada SET urutan = -1 WHERE id = ?', [$armada->id]);

                if ($urutanBaru < $urutanLama) {
                    DB::statement('
                        UPDATE armada SET urutan = urutan + 1
                        WHERE urutan >= ? AND urutan < ?
                        ORDER BY urutan DESC
                    ', [$urutanBaru, $urutanLama]);
                } else {
                    DB::statement('
                        UPDATE armada SET urutan = urutan - 1
                        WHERE urutan > ? AND urutan <= ?
                        ORDER BY urutan ASC
                    ', [$urutanLama, $urutanBaru]);
                }

                $validated['urutan'] = $urutanBaru;
                $armada->fill($validated);
                $armada->save();
            });
        } else {
            $armada->update($validated);
        }

        return redirect()->route('admin.armada.index')
            ->with('success', 'Armada "'.$armada->nama.'" berhasil diperbarui'.
                ($urutanLama != $urutanBaru
                    ? ', urutan dipindah dari '.$urutanLama.' ke '.$urutanBaru
                    : '').'.');
    }

    public function destroy(Armada $armada)
    {
        $urutanDihapus = $armada->urutan;
        $namaArmada = $armada->nama;

        DB::transaction(function () use ($armada, $urutanDihapus) {
            if ($armada->gambar_utama) {
                ImageHelper::delete($armada->gambar_utama);
            }

            if ($armada->galeri && is_array($armada->galeri)) {
                foreach ($armada->galeri as $galeriPath) {
                    ImageHelper::delete($galeriPath);
                }
            }

            $armada->delete();

            DB::statement('
                UPDATE armada SET urutan = urutan - 1
                WHERE urutan > ?
                ORDER BY urutan ASC
            ', [$urutanDihapus]);
        });

        return redirect()->route('admin.armada.index')
            ->with('success', 'Armada "'.$namaArmada.'" berhasil dihapus dan urutan disesuaikan.');
    }

    public function deleteGaleriImage(Request $request, Armada $armada)
    {
        $request->validate([
            'image_path' => 'required|string',
        ], [
            'image_path.required' => 'Path gambar wajib disertakan.',
        ]);

        $imagePath = $request->image_path;
        $galeri = $armada->galeri ?? [];

        if (! in_array($imagePath, $galeri)) {
            return response()->json([
                'success' => false,
                'message' => 'Gambar tidak ditemukan di galeri armada ini.',
            ], 404);
        }

        ImageHelper::delete($imagePath);

        $galeri = array_values(array_filter($galeri, fn ($p) => $p !== $imagePath));
        $armada->galeri = $galeri;
        $armada->save();

        return response()->json([
            'success' => true,
            'message' => 'Gambar berhasil dihapus dari galeri.',
            'remaining' => count($galeri),
        ]);
    }

    private function generateUniqueSlug(string $nama, ?int $exceptId = null): string
    {
        $baseSlug = Str::slug($nama);

        if (empty($baseSlug)) {
            $baseSlug = 'armada';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (true) {
            $query = Armada::where('slug', $slug);

            if ($exceptId !== null) {
                $query->where('id', '!=', $exceptId);
            }

            if (! $query->exists()) {
                break;
            }

            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
