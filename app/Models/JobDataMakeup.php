<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDataMakeup extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_data_makeups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_job_booking',
        'jenis_makeup',
        'busana_akad_perempuan',
        'busana_akad_laki',
        'busana_temu_perempuan',
        'busana_temu_laki',
        'busana_ganti_perempuan',
        'busana_ganti_laki',
        'bunga_melati',
        'catatan_makeup',
        'mua_nikah',
        'mua_resepsi',
        'asisten_nikah',
        'asisten_resepsi',
        'tambahan_gown',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tambahan_gown' => 'array',
    ];

    /**
     * Get the job booking that owns the makeup data.
     */
    public function jobBooking()
    {
        return $this->belongsTo(JobBooking::class, 'id_job_booking');
    }
}
