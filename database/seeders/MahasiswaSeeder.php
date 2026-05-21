<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nim' => '21010001', 'nama' => 'Andi Pratama',   'kelas' => 'TI-4A', 'nfc_serial' => null],
            ['nim' => '21010002', 'nama' => 'Budi Santoso',   'kelas' => 'TI-4A', 'nfc_serial' => null],
            ['nim' => '21010003', 'nama' => 'Citra Lestari',  'kelas' => 'TI-4B', 'nfc_serial' => null],
            ['nim' => '21010004', 'nama' => 'Dewi Anggraini', 'kelas' => 'TI-4B', 'nfc_serial' => null],
            ['nim' => '21010005', 'nama' => 'Eko Wibowo',     'kelas' => 'TI-4C', 'nfc_serial' => null],
        ];

        foreach ($data as $row) {
            Mahasiswa::updateOrCreate(['nim' => $row['nim']], $row);
        }
    }
}
