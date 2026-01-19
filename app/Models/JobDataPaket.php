<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDataPaket extends Model
{
    use HasFactory;

    protected $table = 'job_data_pakets';

    protected $fillable = [
        'id_job_booking',
        'tambahan_dp',
        'nilai_paket',
        'nilai_dp',
        'nilai_tambahan_item',
        'sisa_bayar',
        'catatan_paket',
        'set_pendamping',
        'dekorasi_kode',
        'dekorasi_tw',
        'dekorasi_admin',
    ];

    protected $casts = [
        'id_job_booking' => 'integer',
        'tambahan_dp' => 'decimal:2',
        'nilai_paket' => 'decimal:2',
        'nilai_dp' => 'decimal:2',
        'nilai_tambahan_item' => 'decimal:2',
        'sisa_bayar' => 'decimal:2',
    ];

    /**
     * Relasi dengan JobBooking
     */
    public function jobBooking()
    {
        return $this->belongsTo(JobBooking::class, 'id_job_booking');
    }
}
