<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterJenisItemPaket extends Model
{
    use HasFactory;

    protected $table = 'master_jenis_item_paket';

    protected $fillable = [
        'nama_jenis',
        'order_jenis',
        'deskripsi'
    ];

    /**
     * Relationship with MasterItemPaket
     */
    public function itemPakets()
    {
        return $this->hasMany(MasterItemPaket::class, 'id_jenis');
    }
    protected $hidden = [
        'updated_at',
        'created_at',
    ];
    /**
     * Get the user's email verified at date formatted.
     */
    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
