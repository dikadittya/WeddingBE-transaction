<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegRegencies extends Model
{
    use HasFactory;

    protected $table = 'reg_regencies';

    protected $fillable = [
        'id',
        'province_id',
        'name'
    ];

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    /**
     * Get the province that owns the regency.
     */
    public function province()
    {
        return $this->belongsTo(RegProvinces::class, 'province_id');
    }
}