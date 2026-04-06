<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeonardoBukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('buku')->updateOrInsert(
            ['kode' => 'B021'],
            [
                'judul' => 'Leonardo da Vinci',
                'pengarang' => 'Walter Isaacson',
                'idkategori' => 4, // History
            ]
        );
    }
}
