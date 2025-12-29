<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobBooking extends Model
{
    use HasFactory;

    protected $table = 'job_booking';

    protected $fillable = [
        'tanggal_job',
        'jenis_job',
        'nilai_dp',
        'nama_catin',
        'alamat_desa',
        'alamat_kec_id',
        'alamat_kec',
        'alamat_kab_id',
        'alamat_kab',
        'alamat_prov_id',
        'alamat_prov',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_job' => 'date',
        'nilai_dp' => 'decimal:2',
    ];

    /**
     * Relasi dengan User yang membuat booking
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
