<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterItemPaketHarga extends Model
{
    use HasFactory;

    protected $table = 'master_item_paket_harga';

    protected $fillable = [
        'id_master_item_paket',
        'harga',
        'id_master_mua'
    ];

    protected $casts = [
        'harga' => 'decimal:2'
    ];
}
