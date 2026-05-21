<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NfcAbsensi extends Model
{
    protected $table = 'nfc_absensi';

    protected $fillable = [
        'mahasiswa_id',
        'tipe',
        'waktu',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
}
