<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    public $timestamps = false;
    protected $primaryKey = 'id_barang';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id_barang',
        'nama',
        'harga',
        'timestamp'
    ];
}
