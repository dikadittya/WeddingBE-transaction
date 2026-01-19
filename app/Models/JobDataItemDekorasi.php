<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobDataItemDekorasi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_data_item_dekorasis';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_job_booking',
        'item_dekorasi',
    ];

    /**
     * Get the job booking that owns the item dekorasi.
     */
    public function jobBooking()
    {
        return $this->belongsTo(JobBooking::class, 'id_job_booking');
    }
}
