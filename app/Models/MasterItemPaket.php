<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterItemPaket extends Model
{
    use HasFactory;

    protected $table = 'master_item_paket';

    protected $fillable = [
        'id_jenis',
        'nama_item',
        'order_item',
        'tipe'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
    ];
    protected $casts = [
        'tipe' => 'string'
    ];

    /**
     * Relationship with MasterJenisItemPaket
     */
    public function jenisItemPaket()
    {
        return $this->belongsTo(MasterJenisItemPaket::class, 'id_jenis');
    }

    /**
     * Relationship with MasterItemPaketHarga
     */
    public function harga()
    {
        return $this->hasMany(MasterItemPaketHarga::class, 'id_master_item_paket');
    }
}
