<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaDetail extends Model
{
    use HasFactory;
    protected $table = 'nota_detail';

    protected $fillable = [
        'qty',
        'nama',
        'harga',
        'total',
        'nota_id'
    ];
}
