<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->get();
        $kategori = \App\Models\Kategori::all();
        return view('admin.buku.TampilanBuku', compact('buku', 'kategori'));
    }

    public function create()
    {
        $kategori = \App\Models\Kategori::all();
        return view('admin.buku.tambah', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:buku',
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'idkategori' => 'required|exists:kategori,idkategori',
        ]);

        Buku::create($request->all());

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = \App\Models\Kategori::all();
        return view('admin.buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:10|unique:buku,kode,'.$id.',idbuku',
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'idkategori' => 'required|exists:kategori,idkategori',
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update($request->all());

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
