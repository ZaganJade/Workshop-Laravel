<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            ['kode' => 'B001', 'judul' => 'Clean Code', 'pengarang' => 'Robert C. Martin', 'idkategori' => 1],
            ['kode' => 'B002', 'judul' => 'Cracking the Coding Interview', 'pengarang' => 'Gayle Laakmann McDowell', 'idkategori' => 1],
            ['kode' => 'B003', 'judul' => 'Design Patterns', 'pengarang' => 'Erich Gamma et al.', 'idkategori' => 1],
            ['kode' => 'B004', 'judul' => 'Refactoring', 'pengarang' => 'Martin Fowler', 'idkategori' => 1],
            ['kode' => 'B005', 'judul' => 'JavaScript: The Good Parts', 'pengarang' => 'Douglas Crockford', 'idkategori' => 1],

            ['kode' => 'B006', 'judul' => 'The Great Gatsby', 'pengarang' => 'F. Scott Fitzgerald', 'idkategori' => 2],
            ['kode' => 'B007', 'judul' => '1984', 'pengarang' => 'George Orwell', 'idkategori' => 2],
            ['kode' => 'B008', 'judul' => 'To Kill a Mockingbird', 'pengarang' => 'Harper Lee', 'idkategori' => 2],
            ['kode' => 'B009', 'judul' => 'Brave New World', 'pengarang' => 'Aldous Huxley', 'idkategori' => 2],
            ['kode' => 'B010', 'judul' => 'The Catcher in the Rye', 'pengarang' => 'J.D. Salinger', 'idkategori' => 2],

            ['kode' => 'B011', 'judul' => 'A Brief History of Time', 'pengarang' => 'Stephen Hawking', 'idkategori' => 3],
            ['kode' => 'B012', 'judul' => 'The Selfish Gene', 'pengarang' => 'Richard Dawkins', 'idkategori' => 3],
            ['kode' => 'B013', 'judul' => 'Cosmos', 'pengarang' => 'Carl Sagan', 'idkategori' => 3],
            ['kode' => 'B014', 'judul' => 'The Elegant Universe', 'pengarang' => 'Brian Greene', 'idkategori' => 3],
            ['kode' => 'B015', 'judul' => 'Sapiens', 'pengarang' => 'Yuval Noah Harari', 'idkategori' => 3],

            ['kode' => 'B016', 'judul' => 'Guns, Germs, and Steel', 'pengarang' => 'Jared Diamond', 'idkategori' => 4],
            ['kode' => 'B017', 'judul' => 'The Silk Roads', 'pengarang' => 'Peter Frankopan', 'idkategori' => 4],
            ['kode' => 'B018', 'judul' => 'Thinking, Fast and Slow', 'pengarang' => 'Daniel Kahneman', 'idkategori' => 5],
            ['kode' => 'B019', 'judul' => 'Atomic Habits', 'pengarang' => 'James Clear', 'idkategori' => 5],
            ['kode' => 'B020', 'judul' => 'Deep Work', 'pengarang' => 'Cal Newport', 'idkategori' => 5],
        ];

        DB::table('buku')->insert($books);
    }
}
