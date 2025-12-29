<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegProvinces extends Model
{
    use HasFactory;

    protected $table = 'reg_provinces';

    protected $fillable = [
        'id',
        'name'
    ];

    public $timestamps = true;

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    public $incrementing = true;
}