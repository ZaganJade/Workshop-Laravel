<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Programming'],
            ['nama_kategori' => 'Fiction'],
            ['nama_kategori' => 'Science'],
            ['nama_kategori' => 'History'],
            ['nama_kategori' => 'Self-Improvement'],
        ];

        DB::table('kategori')->insert($categories);
    }
}
