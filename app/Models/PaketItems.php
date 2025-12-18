<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketItems extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'paket_items';

    protected $hidden = [
        'updated_at',
        'created_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_paket_master',
        'id_master_item_paket',
        'volume',
    ];

    /**
     * Get the paket master that owns the paket item.
     */
    public function paketMaster()
    {
        return $this->belongsTo(PaketMaster::class, 'id_paket_master');
    }

    /**
     * Get the master item paket that owns the paket item.
     */
    public function masterItemPaket()
    {
        return $this->belongsTo(MasterItemPaket::class, 'id_master_item_paket');
    }
}