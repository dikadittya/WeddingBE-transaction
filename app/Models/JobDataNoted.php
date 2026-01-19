<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDataNoted extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_data_notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_job_booking',
        'tipe_note',
        'isi_note',
    ];

    /**
     * Get the job booking that owns the noted.
     */
    public function jobBooking()
    {
        return $this->belongsTo(JobBooking::class, 'id_job_booking');
    }
}
