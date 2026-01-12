<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobBooking extends Model
{
    use HasFactory;

    protected $table = 'job_booking';

    const STATUS_BOOKING = 0;
    const STATUS_BELUM_TUNTAS = 1;
    const STATUS_TUNTAS = 2;

    const STATUS_LABELS = [
        self::STATUS_BOOKING => 'Booking',
        self::STATUS_BELUM_TUNTAS => 'Belum Tuntas', ///Detail Job Terisi
        self::STATUS_TUNTAS => 'Tuntas', ///Job Selesai
    ];

    protected $fillable = [
        'code_job',
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
        'status_job',
        'keterangan',
        'created_by',
    ];

    protected $casts = [
        'tanggal_job' => 'date:Y-m-d',
        'nilai_dp' => 'decimal:2',
    ];

    /**
     * Relasi dengan User yang membuat booking
     */
    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by')->select('id', 'name', 'username');
    }

    /**
     * Get status job label
     */
    public function getStatusJobLabelAttribute()
    {
        return self::STATUS_LABELS[$this->status_job] ?? 'Unknown';
    }
}
