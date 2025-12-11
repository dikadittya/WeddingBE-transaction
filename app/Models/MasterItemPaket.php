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
        'kategori_paket',
        'tipe'
    ];

    protected $casts = [
        'kategori_paket' => 'string',
        'tipe' => 'string'
    ];

    /**
     * Relationship with MasterJenisItemPaket
     */
    public function jenisItemPaket()
    {
        return $this->belongsTo(MasterJenisItemPaket::class, 'id_jenis');
    }
}
