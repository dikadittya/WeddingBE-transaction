<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDataItemDokumentasi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_data_item_dokumentasis';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_job_booking',
        'item_dokumentasi',
        'volume',
        'dokumentasi_tw',
        'dokumentasi_admin',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'volume' => 'integer',
    ];

    /**
     * Get the job booking that owns the item dokumentasi.
     */
    public function jobBooking()
    {
        return $this->belongsTo(JobBooking::class, 'id_job_booking');
    }
}
