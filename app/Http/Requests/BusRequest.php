<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $busId = $this->route('bu'); // 'bu' karena resource route untuk bus

        return [
            'kode_bus' => [
                'required',
                'string',
                'max:50',
                Rule::unique('bus', 'kode_bus')->ignore($busId),
            ],
            'nama_bus' => 'required|string|max:255',
            'kategori_bus_id' => 'required|exists:kategori_bus,id',
            'sopir_id' => [
                'required',
                'exists:sopir,id',
                Rule::unique('bus', 'sopir_id')->ignore($busId),
            ],
            'warna_bus' => 'required|string|max:50',
            'nomor_polisi' => [
                'required',
                'string',
                'max:20',
                Rule::unique('bus', 'nomor_polisi')->ignore($busId),
            ],
            'status' => 'required|in:aktif,perawatan',
        ];
    }

    public function messages(): array
    {
        return [
            'kode_bus.required' => 'Kode bus wajib diisi',
            'kode_bus.unique' => 'Kode bus sudah digunakan',
            'nama_bus.required' => 'Nama bus wajib diisi',
            'kategori_bus_id.required' => 'Kategori bus wajib dipilih',
            'kategori_bus_id.exists' => 'Kategori bus tidak valid',
            'sopir_id.required' => 'Sopir wajib dipilih',
            'sopir_id.exists' => 'Sopir tidak valid',
            'sopir_id.unique' => 'Sopir sudah ditugaskan ke bus lain',
            'warna_bus.required' => 'Warna bus wajib diisi',
            'nomor_polisi.required' => 'Nomor polisi wajib diisi',
            'nomor_polisi.unique' => 'Nomor polisi sudah terdaftar',
            'status.required' => 'Status bus wajib dipilih',
            'status.in' => 'Status bus hanya boleh aktif atau perawatan',
        ];
    }
}
