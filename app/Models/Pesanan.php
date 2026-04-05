<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $primaryKey = 'idpesanan';
    protected $fillable = ['user_id', 'nama', 'total', 'status_bayar', 'paid_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function details()
    {
        return $this->hasMany(DetailPesanan::class, 'idpesanan', 'idpesanan');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'idpesanan', 'idpesanan');
    }
}
