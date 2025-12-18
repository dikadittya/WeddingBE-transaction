<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketMaster extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'paket_master';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_mua',
        'nama_paket',
        'jenis_paket',
    ];

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
    /**
     * Get the MUA that owns the paket.
     */
    public function mua()
    {
        return $this->belongsTo(MasterMua::class, 'id_mua')->select('id', 'nama_mua');
    }

    /**
     * Get the paket items for the paket master.
     */
    public function paketItems()
    {
        return $this->hasMany(PaketItems::class, 'id_paket_master')->with('masterItemPaket');
    }
}