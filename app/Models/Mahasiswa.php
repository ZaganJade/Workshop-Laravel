<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $fillable = [
        'nim',
        'nama',
        'kelas',
        'nfc_serial',
    ];

    /**
     * Normalisasi serial saat di-set: trim + uppercase.
     */
    public function setNfcSerialAttribute($value): void
    {
        $this->attributes['nfc_serial'] = $value === null
            ? null
            : strtoupper(trim($value));
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(NfcAbsensi::class, 'mahasiswa_id');
    }
}
