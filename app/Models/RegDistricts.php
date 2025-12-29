<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegDistricts extends Model
{
    use HasFactory;

    protected $table = 'reg_districts';

    protected $fillable = [
        'id',
        'regency_id',
        'name'
    ];

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;

    /**
     * Get the regency that owns the district.
     */
    public function regency()
    {
        return $this->belongsTo(RegRegencies::class, 'regency_id');
    }
}