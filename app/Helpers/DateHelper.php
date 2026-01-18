<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    // set zona waktu ke WIB
    public static function setDefaultTimezone()
    {
        date_default_timezone_set('Asia/Jakarta');
        Carbon::setLocale('id');
    }

    // format tanggal ke indonesia
    public static function formatIndonesia($date, $format = 'd F Y')
    {
        if (!$date) return '-';
        
        return Carbon::parse($date)->locale('id')->translatedFormat($format);
    }

    // format tanggal dan waktu ke indonesia
    public static function formatDateTimeIndonesia($datetime)
    {
        if (!$datetime) return '-';
        
        return Carbon::parse($datetime)->locale('id')->translatedFormat('d F Y H:i');
    }

    // mendapatkan waktu sekarang
    public static function now()
    {
        return Carbon::now('Asia/Jakarta');
    }

    // mendapatkan tanggal sekarang
    public static function today()
    {
        return Carbon::today('Asia/Jakarta');
    }

    // parse tanggal ke carbon dengan zona waktu WIB
    public static function parse($date)
    {
        return Carbon::parse($date, 'Asia/Jakarta');
    }

    // mendapatkan range tanggal bahasa indonesia
    public static function formatDateRange($startDate, $endDate)
    {
        if (!$startDate || !$endDate) return '-';
        
        $start = Carbon::parse($startDate)->locale('id');
        $end = Carbon::parse($endDate)->locale('id');
        
        if ($start->isSameDay($end)) {
            return $start->translatedFormat('d F Y');
        }
        
        if ($start->isSameMonth($end)) {
            return $start->translatedFormat('d') . ' - ' . $end->translatedFormat('d F Y');
        }
        
        return $start->translatedFormat('d F Y') . ' - ' . $end->translatedFormat('d F Y');
    }

    // hitung selisih hari antara dua tanggal
    public static function diffInDays($startDate, $endDate)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        
        return $start->diffInDays($end) + 1; // +1 karena termasuk hari pertama
    }

    // mendapatkan nama bulan indo
    public static function getBulanIndonesia($month = null)
    {
        $month = $month ?? date('n');
        
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        
        return $bulan[$month] ?? '';
    }

    // mendapatkan list tahun untuk dropdown
    public static function getListTahun($startYear = null)
    {
        $startYear = $startYear ?? 2020;
        $currentYear = date('Y');
        $years = [];
        
        for ($year = $currentYear; $year >= $startYear; $year--) {
            $years[$year] = $year;
        }
        
        return $years;
    }

    // mendapatkan list bulan
    public static function getListBulan()
    {
        return [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
            4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
    }

    // format rupiah
    public static function formatRupiah($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    // mendapatkan tanggal awal dan akhir bulan
    public static function getMonthRange($month = null, $year = null)
    {
        $month = $month ?? date('n');
        $year = $year ?? date('Y');
        
        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = Carbon::create($year, $month, 1)->endOfMonth();
        
        return [
            'start' => $startDate,
            'end' => $endDate
        ];
    }
    // cek tanggal dimasaa depan
    public static function isFuture($date)
    {
        return Carbon::parse($date)->isFuture();
    }

    /**
     * Check apakah tanggal di masa lalu
     */
    public static function isPast($date)
    {
        return Carbon::parse($date)->isPast();
    }

    // mendapatkan waktu relatif misalnya 2 hari yang lalu
    public static function diffForHumans($date)
    {
        return Carbon::parse($date)->locale('id')->diffForHumans();
    }
}