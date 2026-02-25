<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateHelper;
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
            'gambar' => 'required|image|mimes:jpeg,jpg,png|max:10240',
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
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',
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

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->handleImageUpload($request->file('gambar'), 'layanan');
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
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
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
            'gambar.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',
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

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->handleImageUpload(
                $request->file('gambar'),
                'layanan',
                $layanan->gambar
            );
        }

        $urutanLama = $layanan->urutan;
        $urutanBaru = $validated['urutan'];

        if ($urutanLama != $urutanBaru) {
            DB::transaction(function () use ($layanan, $urutanLama, $urutanBaru, $validated) {
                $maxUrutan = Layanan::max('urutan');
                $tempValue = $maxUrutan + 1000;

                $layanan->timestamps = false;
                $layanan->urutan = $tempValue;
                $layanan->save();

                if ($urutanBaru < $urutanLama) {
                    Layanan::where('urutan', '>=', $urutanBaru)
                        ->where('urutan', '<', $urutanLama)
                        ->increment('urutan');
                } else {
                    Layanan::where('urutan', '<=', $urutanBaru)
                        ->where('urutan', '>', $urutanLama)
                        ->decrement('urutan');
                }

                $layanan->timestamps = true;
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
            $this->handleImageDelete($layanan->gambar);
            $layanan->delete();

            Layanan::where('urutan', '>', $urutanDihapus)->decrement('urutan');
        });

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus pada '.DateHelper::formatDateTimeIndonesia(DateHelper::now()));
    }

    protected function handleImageUpload($file, $folder, $oldImage = null)
    {
        if ($oldImage) {
            $this->handleImageDelete($oldImage);
        }

        $path = public_path('uploads/'.$folder);
        if (! file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($path, $filename);

        return 'uploads/'.$folder.'/'.$filename;
    }

    protected function handleImageDelete($imagePath)
    {
        if ($imagePath && file_exists(public_path($imagePath))) {
            unlink(public_path($imagePath));
        }
    }
}
