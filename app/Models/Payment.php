<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'idpesanan',
        'order_id_midtrans',
        'transaction_id',
        'payment_type',
        'bank',
        'gross_amount',
        'status',
        'raw_response'
    ];

    protected $casts = [
        'raw_response' => 'array'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'idpesanan', 'idpesanan');
    }
}
