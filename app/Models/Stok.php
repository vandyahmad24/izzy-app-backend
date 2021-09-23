<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;
    protected $table = 'stok';

    protected $fillable = [
        'kategori_id',
        'nama',
        'qty_22',
        'qty_33',
    ];
}
