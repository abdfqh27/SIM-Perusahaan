<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Armada;
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
        $armadas = Armada::orderBy('urutan')->get();

        return view('admin.armada.index', compact('armadas'));
    }

    public function create()
    {
        $nextUrutan = Armada::max('urutan') + 1;
        $daftarTipeBus = Armada::getDaftarTipeBus();

        return view('admin.armada.create', compact('nextUrutan', 'daftarTipeBus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:armada,nama',
            'tipe_bus' => 'required|string|max:50',
            'kapasitas_min' => 'required|integer|min:1',
            'kapasitas_max' => 'required|integer|min:1|gte:kapasitas_min',
            'deskripsi' => 'nullable|string',
            'gambar_utama' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'galeri.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:100',
            'unggulan' => 'boolean',
            'tersedia' => 'boolean',
        ], [
            'nama.required' => 'Nama armada wajib diisi.',
            'nama.string' => 'Nama armada harus berupa teks.',
            'nama.max' => 'Nama armada tidak boleh lebih dari 255 karakter.',
            'nama.unique' => 'Nama armada tersebut sudah digunakan, silakan gunakan nama yang berbeda.',
            'tipe_bus.required' => 'Tipe bus wajib dipilih.',
            'tipe_bus.string' => 'Tipe bus harus berupa teks.',
            'tipe_bus.max' => 'Tipe bus tidak boleh lebih dari 50 karakter.',
            'kapasitas_min.required' => 'Kapasitas minimum wajib diisi.',
            'kapasitas_min.integer' => 'Kapasitas minimum harus berupa angka.',
            'kapasitas_min.min' => 'Kapasitas minimum tidak boleh kurang dari 1.',
            'kapasitas_max.required' => 'Kapasitas maximum wajib diisi.',
            'kapasitas_max.integer' => 'Kapasitas maximum harus berupa angka.',
            'kapasitas_max.min' => 'Kapasitas maximum tidak boleh kurang dari 1.',
            'kapasitas_max.gte' => 'Kapasitas maximum harus lebih besar atau sama dengan kapasitas minimum.',
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

        // Slug otomatis dari nama, dijamin unik
        $validated['slug'] = $this->generateUniqueSlug($validated['nama']);

        // Upload gambar utama jika ada (convert ke WebP HD)
        if ($request->hasFile('gambar_utama')) {
            $validated['gambar_utama'] = ImageHelper::uploadHDWebP(
                $request->file('gambar_utama'),
                'armada',
                1920,
                90
            );
        }

        // Upload galeri jika ada (convert ke WebP HD)
        $galeriPaths = [];
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $galeriFile) {
                $galeriPaths[] = ImageHelper::uploadHDWebP(
                    $galeriFile,
                    'armada/galeri',
                    1920,
                    90
                );
            }
        }
        $validated['galeri'] = $galeriPaths;

        // Urutan otomatis di posisi terakhir
        $validated['urutan'] = Armada::max('urutan') + 1;

        $armada = Armada::create($validated);

        return redirect()->route('admin.armada.index')
            ->with('success', 'Armada "'.$armada->nama.'" berhasil ditambahkan ke urutan '.$armada->urutan.'.');
    }

    public function show(Armada $armada)
    {
        return view('admin.armada.show', compact('armada'));
    }

    public function edit(Armada $armada)
    {
        $allArmadas = Armada::orderBy('urutan')->get();
        $maxUrutan = Armada::max('urutan');
        $daftarTipeBus = Armada::getDaftarTipeBus();

        return view('admin.armada.edit', compact('armada', 'allArmadas', 'maxUrutan', 'daftarTipeBus'));
    }

    public function update(Request $request, Armada $armada)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:armada,nama,'.$armada->id,
            'tipe_bus' => 'required|string|max:50',
            'kapasitas_min' => 'required|integer|min:1',
            'kapasitas_max' => 'required|integer|min:1|gte:kapasitas_min',
            'deskripsi' => 'nullable|string',
            'gambar_utama' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'galeri.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:100',
            'urutan' => [
                'required',
                'integer',
                'min:1',
                'max:'.Armada::max('urutan'),
            ],
            'unggulan' => 'boolean',
            'tersedia' => 'boolean',
        ], [
            'nama.required' => 'Nama armada wajib diisi.',
            'nama.string' => 'Nama armada harus berupa teks.',
            'nama.max' => 'Nama armada tidak boleh lebih dari 255 karakter.',
            'nama.unique' => 'Nama armada tersebut sudah digunakan, silakan gunakan nama yang berbeda.',
            'tipe_bus.required' => 'Tipe bus wajib dipilih.',
            'tipe_bus.string' => 'Tipe bus harus berupa teks.',
            'tipe_bus.max' => 'Tipe bus tidak boleh lebih dari 50 karakter.',
            'kapasitas_min.required' => 'Kapasitas minimum wajib diisi.',
            'kapasitas_min.integer' => 'Kapasitas minimum harus berupa angka.',
            'kapasitas_min.min' => 'Kapasitas minimum tidak boleh kurang dari 1.',
            'kapasitas_max.required' => 'Kapasitas maximum wajib diisi.',
            'kapasitas_max.integer' => 'Kapasitas maximum harus berupa angka.',
            'kapasitas_max.min' => 'Kapasitas maximum tidak boleh kurang dari 1.',
            'kapasitas_max.gte' => 'Kapasitas maximum harus lebih besar atau sama dengan kapasitas minimum.',
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
            'urutan.max' => 'Urutan tampilan tidak boleh lebih dari '.Armada::max('urutan').'.',
        ]);

        // Slug otomatis dari nama (kecualikan armada yang sedang diedit agar tidak bentrok dengan slug miliknya sendiri)
        $validated['slug'] = $this->generateUniqueSlug($validated['nama'], $armada->id);

        $urutanLama = $armada->urutan;
        $urutanBaru = $validated['urutan'];

        // Upload gambar utama baru jika ada, hapus yang lama terlebih dahulu
        if ($request->hasFile('gambar_utama')) {
            if ($armada->gambar_utama) {
                ImageHelper::delete($armada->gambar_utama);
            }
            $validated['gambar_utama'] = ImageHelper::uploadHDWebP(
                $request->file('gambar_utama'),
                'armada',
                1920,
                90
            );
        }

        // Galeri: pertahankan yang sudah ada di DB (setelah AJAX delete),
        // lalu tambahkan yang baru di-upload
        $galeriPaths = $armada->galeri ?? [];

        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $galeriFile) {
                $galeriPaths[] = ImageHelper::uploadHDWebP(
                    $galeriFile,
                    'armada/galeri',
                    1920,
                    90
                );
            }
        }
        $validated['galeri'] = $galeriPaths;

        if ($urutanLama != $urutanBaru) {
            DB::transaction(function () use ($armada, $urutanLama, $urutanBaru, $validated) {

                // Langkah 1: Parkir armada yang diedit ke urutan sementara (negatif)
                DB::statement('UPDATE armada SET urutan = -1 WHERE id = ?', [$armada->id]);

                if ($urutanBaru < $urutanLama) {
                    // Pindah ke atas (contoh: urutan 3 -> 1)
                    // Armada di urutan 1, 2 harus bergeser ke 2, 3
                    // ORDER BY DESC: proses terbesar dulu (2->3, lalu 1->2) → tidak bentrok
                    DB::statement('
                        UPDATE armada
                        SET urutan = urutan + 1
                        WHERE urutan >= ?
                          AND urutan < ?
                        ORDER BY urutan DESC
                    ', [$urutanBaru, $urutanLama]);
                } else {
                    // Pindah ke bawah (contoh: urutan 1 -> 3)
                    // Armada di urutan 2, 3 harus bergeser ke 1, 2
                    // ORDER BY ASC: proses terkecil dulu (2->1, lalu 3->2) → tidak bentrok
                    DB::statement('
                        UPDATE armada
                        SET urutan = urutan - 1
                        WHERE urutan > ?
                          AND urutan <= ?
                        ORDER BY urutan ASC
                    ', [$urutanLama, $urutanBaru]);
                }

                // Langkah 3: Pindahkan armada ke urutan tujuan yang sudah kosong
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
            // Hapus gambar utama dari storage
            if ($armada->gambar_utama) {
                ImageHelper::delete($armada->gambar_utama);
            }

            // Hapus semua gambar galeri dari storage
            if ($armada->galeri && is_array($armada->galeri)) {
                foreach ($armada->galeri as $galeriPath) {
                    ImageHelper::delete($galeriPath);
                }
            }

            $armada->delete();

            // Rapikan urutan: semua armada di bawahnya naik satu
            // ORDER BY ASC agar decrement tidak bentrok unique constraint
            DB::statement('
                UPDATE armada
                SET urutan = urutan - 1
                WHERE urutan > ?
                ORDER BY urutan ASC
            ', [$urutanDihapus]);
        });

        return redirect()->route('admin.armada.index')
            ->with('success', 'Armada "'.$namaArmada.'" berhasil dihapus dan urutan disesuaikan.');
    }

    // AJAX: Hapus satu gambar galeri — langsung hapus dari storage & DB

    public function deleteGaleriImage(Request $request, Armada $armada)
    {
        $request->validate([
            'image_path' => 'required|string',
        ], [
            'image_path.required' => 'Path gambar wajib disertakan.',
            'image_path.string' => 'Path gambar tidak valid.',
        ]);

        $imagePath = $request->image_path;
        $galeri = $armada->galeri ?? [];

        if (! in_array($imagePath, $galeri)) {
            return response()->json([
                'success' => false,
                'message' => 'Gambar tidak ditemukan di galeri armada ini.',
            ], 404);
        }

        // Hapus file dari storage
        ImageHelper::delete($imagePath);

        // Hapus dari array & simpan perubahan ke DB
        $galeri = array_values(array_filter($galeri, fn ($p) => $p !== $imagePath));

        $armada->galeri = $galeri;
        $armada->save();

        return response()->json([
            'success' => true,
            'message' => 'Gambar berhasil dihapus dari galeri.',
            'remaining' => count($galeri),
        ]);
    }

    // HELPER PRIVATE: Generate slug unik dari nama
    // Loop sampai menemukan slug yang belum dipakai di database

    private function generateUniqueSlug(string $nama, ?int $exceptId = null): string
    {
        $baseSlug = Str::slug($nama);

        // Fallback jika nama hanya karakter non-latin (arab, emoji, dll)
        if (empty($baseSlug)) {
            $baseSlug = 'armada';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (true) {
            $query = Armada::where('slug', $slug);

            // Saat update: kecualikan armada yang sedang diedit
            if ($exceptId !== null) {
                $query->where('id', '!=', $exceptId);
            }

            if (! $query->exists()) {
                break; // slug belum dipakai, aman digunakan
            }

            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
