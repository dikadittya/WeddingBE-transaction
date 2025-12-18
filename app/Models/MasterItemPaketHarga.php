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
        'kategori',
        'id_master_mua'
    ];

    protected $casts = [
        'harga' => 'decimal:2'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];
    /**
     * Relationship with MasterItemPaket
     */
    public function masterItemPaket()
    {
        return $this->belongsTo(MasterItemPaket::class, 'id_master_item_paket');
    }

    /**
     * Relationship with MasterMua
     */
    public function masterMua()
    {
        return $this->belongsTo(MasterMua::class, 'id_master_mua');
    }
}
