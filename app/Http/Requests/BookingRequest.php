<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'nama_pemesan' => 'required|string|max:255',
            'no_hp_pemesan' => 'required|string|max:15',
            'email_pemesan' => 'nullable|email|max:255',
            'tujuan' => 'required|string|max:255',
            'tempat_jemput' => 'required|string|max:255',
            'tanggal_berangkat' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_berangkat',
            'jam_berangkat' => 'required|date_format:H:i',
            'total_pembayaran' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:cash,transfer',
            'status_pembayaran' => 'required|in:belum_bayar,dp,lunas',
            'status_booking' => 'required|in:draft,confirmed,selesai,batal',
            'catatan' => 'nullable|string',
            'bus_ids' => 'required|array|min:1',
            'bus_ids.*' => 'exists:bus,id',
        ];

        // Validasi nominal DP berdasarkan status pembayaran
        if ($this->status_pembayaran === 'dp') {
            $rules['nominal_dp'] = 'required|numeric|min:1|lte:total_pembayaran';
        } elseif ($this->status_pembayaran === 'lunas') {
            // Nominal DP akan di-set otomatis di prepareForValidation
            $rules['nominal_dp'] = 'nullable|numeric';
        } else {
            $rules['nominal_dp'] = 'nullable|numeric|min:0';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'nama_pemesan.required' => 'Nama pemesan wajib diisi',
            'no_hp_pemesan.required' => 'Nomor HP pemesan wajib diisi',
            'email_pemesan.email' => 'Format email tidak valid',
            'tujuan.required' => 'Tujuan wajib diisi',
            'tempat_jemput.required' => 'Tempat jemput wajib diisi',
            'tanggal_berangkat.required' => 'Tanggal berangkat wajib diisi',
            'tanggal_berangkat.after_or_equal' => 'Tanggal berangkat tidak boleh kurang dari hari ini',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh lebih kecil dari tanggal berangkat',
            'jam_berangkat.required' => 'Jam berangkat wajib diisi',
            'jam_berangkat.date_format' => 'Format jam tidak valid (HH:MM)',
            'total_pembayaran.required' => 'Total pembayaran wajib diisi',
            'total_pembayaran.min' => 'Total pembayaran minimal 0',
            'nominal_dp.required' => 'Nominal DP wajib diisi untuk pembayaran DP',
            'nominal_dp.lte' => 'Nominal DP tidak boleh lebih dari total pembayaran',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih',
            'status_pembayaran.required' => 'Status pembayaran wajib dipilih',
            'status_booking.required' => 'Status booking wajib dipilih',
            'bus_ids.required' => 'Minimal pilih 1 bus',
            'bus_ids.min' => 'Minimal pilih 1 bus',
            'bus_ids.*.exists' => 'Bus tidak valid',
        ];
    }

    protected function prepareForValidation()
    {
        // Auto-set nominal DP jika status pembayaran lunas
        if ($this->status_pembayaran === 'lunas') {
            $this->merge([
                'nominal_dp' => $this->total_pembayaran,
            ]);
        }
    }

    /**
     * Validasi tambahan setelah rules dasar
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validasi ketersediaan bus pada rentang tanggal
            if ($this->has('bus_ids') && $this->has('tanggal_berangkat') && $this->has('tanggal_selesai')) {
                $this->validateBusAvailability($validator);
            }
        });
    }

    /**
     * Validasi ketersediaan bus
     */
    private function validateBusAvailability($validator)
    {
        $busIds = $this->bus_ids;
        $tanggalBerangkat = $this->tanggal_berangkat;
        $tanggalSelesai = $this->tanggal_selesai;
        $excludeBookingId = $this->route('booking') ? $this->route('booking')->id : null;

        foreach ($busIds as $index => $busId) {
            $bus = \App\Models\Bus::find($busId);

            if (! $bus) {
                continue;
            }

            // Cek status bus - harus aktif
            if ($bus->status === 'perawatan') {
                $validator->errors()->add(
                    "bus_ids.{$index}",
                    "Bus {$bus->nama_bus} sedang dalam perawatan dan tidak dapat dipesan"
                );

                continue;
            }

            // Cek konflik dengan booking lain yang confirmed
            $conflict = \App\Models\Booking::where('id', '!=', $excludeBookingId)
                ->where('status_booking', 'confirmed')
                ->whereHas('buses', function ($query) use ($busId) {
                    $query->where('bus_id', $busId);
                })
                ->where(function ($query) use ($tanggalBerangkat, $tanggalSelesai) {
                    // Overlap detection: (Start1 <= End2) AND (End1 >= Start2)
                    $query->whereDate('tanggal_berangkat', '<=', $tanggalSelesai)
                        ->whereDate('tanggal_selesai', '>=', $tanggalBerangkat);
                })
                ->first();

            if ($conflict) {
                $validator->errors()->add(
                    "bus_ids.{$index}",
                    "Bus {$bus->nama_bus} sudah dibooking dari ".
                    $conflict->tanggal_berangkat->format('d/m/Y').
                    ' sampai '.
                    $conflict->tanggal_selesai->format('d/m/Y')
                );
            }
        }
    }
}
