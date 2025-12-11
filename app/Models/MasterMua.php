<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMua extends Model
{
    use HasFactory;

    protected $table = 'master_mua';

    protected $fillable = [
        'nama_mua',
        'is_vendor'
    ];

    protected $casts = [
        'is_vendor' => 'boolean'
    ];
}
