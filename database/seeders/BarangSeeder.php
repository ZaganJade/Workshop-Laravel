<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['id_barang' => 'ELC001', 'nama' => 'Macbook Air M2', 'harga' => 17000000],
            ['id_barang' => 'ELC002', 'nama' => 'ThinkPad X1 Carbon', 'harga' => 22000000],
            ['id_barang' => 'ELC003', 'nama' => 'iPhone 15 Pro', 'harga' => 19000000],
            ['id_barang' => 'ELC004', 'nama' => 'AirPods Pro 2nd Gen', 'harga' => 3500000],
            ['id_barang' => 'ELC005', 'nama' => 'Sony WH-1000XM5', 'harga' => 4500000],

            ['id_barang' => 'FUR001', 'nama' => 'Ergonomic Desk', 'harga' => 1200000],
            ['id_barang' => 'FUR002', 'nama' => 'Herman Miller Aeron', 'harga' => 15000000],
            ['id_barang' => 'FUR003', 'nama' => 'Monitor Stand', 'harga' => 350000],
            ['id_barang' => 'FUR004', 'nama' => 'Bookshelf', 'harga' => 850000],
            ['id_barang' => 'FUR005', 'nama' => 'Floor Lamp', 'harga' => 450000],

            ['id_barang' => 'ACC001', 'nama' => 'Mechanical Keyboard', 'harga' => 1500000],
            ['id_barang' => 'ACC002', 'nama' => 'Logitech MX Master 3S', 'harga' => 1300000],
            ['id_barang' => 'ACC003', 'nama' => 'UltraWide Monitor 34"', 'harga' => 7500000],
            ['id_barang' => 'ACC004', 'nama' => 'External SSD 1TB', 'harga' => 1200000],
            ['id_barang' => 'ACC005', 'nama' => 'Webcam 4K', 'harga' => 1800000],

            ['id_barang' => 'OFF001', 'nama' => 'Pens (12 pack)', 'harga' => 50000],
            ['id_barang' => 'OFF002', 'nama' => 'Notebook Layered', 'harga' => 75000],
            ['id_barang' => 'OFF003', 'nama' => 'Desk Mat', 'harga' => 250000],
            ['id_barang' => 'OFF004', 'nama' => 'Stapler Heavy Duty', 'harga' => 125000],
            ['id_barang' => 'OFF005', 'nama' => 'Whiteboard Markers', 'harga' => 45000],
        ];

        DB::table('barang')->insert($items);
    }
}
