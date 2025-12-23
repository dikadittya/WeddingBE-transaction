<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketUp extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'paket_up';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'jenis_up',
        'id_jenis_item_paket',
        'kode_area',
        'nilai_up',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'nilai_up' => 'decimal:2',
        'jenis_up' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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
     * Get the jenis item paket that owns the paket up.
     */
    public function jenisItemPaket()
    {
        return $this->belongsTo(MasterJenisItemPaket::class, 'id_jenis_item_paket');
    }

    /**
     * Scope a query to only include gedung type.
     */
    public function scopeGedung($query)
    {
        return $query->where('jenis_up', 'gedung');
    }

    /**
     * Scope a query to only include rumahan type.
     */
    public function scopeRumahan($query)
    {
        return $query->where('jenis_up', 'rumahan');
    }

    /**
     * Scope a query to filter by kode area.
     */
    public function scopeByArea($query, $kodeArea)
    {
        return $query->where('kode_area', $kodeArea);
    }

    /**
     * Example usage:
     *
     * // Get all gedung type PaketUp for area 'JKT'
     * PaketUp::gedung()->byArea('JKT')->get();
     *
     * // Get all rumahan type PaketUp for area 'JKT'
     * // PaketUp::rumahan()->byArea('JKT')->get();
    */

    /**
     * Get formatted nilai UP.
     */
    public function getFormattedNilaiUpAttribute()
    {
        return 'Rp ' . number_format($this->nilai_up, 0, ',', '.');
    }
}
