<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $primaryKey = 'idmenu';
    protected $fillable = ['nama_menu', 'harga', 'idvendor', 'path_gambar'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'idvendor', 'idvendor');
    }

    public function detailPesanans()
    {
        return $this->hasMany(DetailPesanan::class, 'idmenu', 'idmenu');
    }
}
