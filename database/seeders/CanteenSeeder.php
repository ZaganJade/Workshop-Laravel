<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CanteenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vendors
        $vendor1 = DB::table('vendors')->insertGetId([
            'nama_vendor' => 'Warung Nasi Mak Nyus',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $vendor2 = DB::table('vendors')->insertGetId([
            'nama_vendor' => 'Mie Ayam Bakso Pak Kumis',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $vendor3 = DB::table('vendors')->insertGetId([
            'nama_vendor' => 'Kantin Sehat 88',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Menus for Vendor 1
        DB::table('menus')->insert([
            ['nama_menu' => 'Nasi Goreng Spesial', 'harga' => 15000, 'idvendor' => $vendor1, 'created_at' => now(), 'updated_at' => now()],
            ['nama_menu' => 'Ayam Penyet', 'harga' => 18000, 'idvendor' => $vendor1, 'created_at' => now(), 'updated_at' => now()],
            ['nama_menu' => 'Es Teh Manis', 'harga' => 5000, 'idvendor' => $vendor1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Menus for Vendor 2
        DB::table('menus')->insert([
            ['nama_menu' => 'Mie Ayam Pangsit', 'harga' => 12000, 'idvendor' => $vendor2, 'created_at' => now(), 'updated_at' => now()],
            ['nama_menu' => 'Bakso Urat', 'harga' => 15000, 'idvendor' => $vendor2, 'created_at' => now(), 'updated_at' => now()],
            ['nama_menu' => 'Es Jeruk', 'harga' => 6000, 'idvendor' => $vendor2, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Menus for Vendor 3
        DB::table('menus')->insert([
            ['nama_menu' => 'Gado-Gado', 'harga' => 13000, 'idvendor' => $vendor3, 'created_at' => now(), 'updated_at' => now()],
            ['nama_menu' => 'Soto Ayam', 'harga' => 15000, 'idvendor' => $vendor3, 'created_at' => now(), 'updated_at' => now()],
            ['nama_menu' => 'Jus Alpukat', 'harga' => 10000, 'idvendor' => $vendor3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
