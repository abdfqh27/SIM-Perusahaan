<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SopirRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sopirId = $this->route('sopir');

        return [
            'nama_sopir' => 'required|string|max:255',
            'nik' => [
                'required',
                'string',
                'size:16',
                Rule::unique('sopir', 'nik')->ignore($sopirId),
            ],
            'no_sim' => [
                'required',
                'string',
                'max:20',
                Rule::unique('sopir', 'no_sim')->ignore($sopirId),
            ],
            'jenis_sim' => 'required|in:SIM A,SIM B1,SIM B2',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'status' => 'required|in:aktif,nonaktif',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_sopir.required' => 'Nama sopir wajib diisi',
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'no_sim.required' => 'Nomor SIM wajib diisi',
            'no_sim.unique' => 'Nomor SIM sudah terdaftar',
            'jenis_sim.required' => 'Jenis SIM wajib dipilih',
            'jenis_sim.in' => 'Jenis SIM tidak valid',
            'no_hp.required' => 'Nomor HP wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'status.required' => 'Status wajib dipilih',
        ];
    }
}
