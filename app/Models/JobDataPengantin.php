<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDataPengantin extends Model
{
    use HasFactory;

    protected $table = 'job_data_pengantins';

    const WAKTU_PAGI = 'p';
    const WAKTU_SIANG = 's';
    const WAKTU_MALAM = 'm';

    const WAKTU_LABELS = [
        self::WAKTU_PAGI => 'Pagi',
        self::WAKTU_SIANG => 'Siang',
        self::WAKTU_MALAM => 'Malam',
    ];

    protected $fillable = [
        'id_job_booking',
        'nama_mua',
        'created_by',
        'waktu_job',
        'waktu_job_jam',
        'waktu_temu',
        'waktu_temu_jam',
        'waktu_resepsi',
        'waktu_resepsi_jam',
        'no_hp',
        'medsos',
        'alamat_resepsi',
        'alamat_akad',
        'petunjuk_arah',
        'url_map_resepsi',
        'url_map_akad',
        'nama_ortu',
    ];

    protected $casts = [
        'id_job_booking' => 'integer',
        'created_by' => 'integer',
    ];

    /**
     * Relasi dengan JobBooking
     */
    public function jobBooking()
    {
        return $this->belongsTo(JobBooking::class, 'id_job_booking');
    }

    /**
     * Relasi dengan User yang membuat data
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get waktu job label
     */
    public function getWaktuJobLabelAttribute()
    {
        return self::WAKTU_LABELS[$this->waktu_job] ?? null;
    }

    /**
     * Get waktu temu label
     */
    public function getWaktuTemuLabelAttribute()
    {
        return self::WAKTU_LABELS[$this->waktu_temu] ?? null;
    }

    /**
     * Get waktu resepsi label
     */
    public function getWaktuResepsiLabelAttribute()
    {
        return self::WAKTU_LABELS[$this->waktu_resepsi] ?? null;
    }
}
