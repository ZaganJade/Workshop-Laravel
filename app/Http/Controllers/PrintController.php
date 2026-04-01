<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;

class PrintController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return view('admin.barang.index', compact('barang'));
    }

    public function print(Request $request)
    {
        $ids = $request->ids ?? [];
        if (empty($ids)) {
            return back()->with('error', 'Silakan pilih minimal 1 barang yang akan dicetak.');
        }

        $data = Barang::whereIn('id_barang', $ids)->get();

        $x = (int) $request->input('x', 1);
        $y = (int) $request->input('y', 1);

        if ($x < 1 || $x > 5 || $y < 1 || $y > 8) {
            return back()->with('error', 'Posisi X (1-5) dan Y (1-8) di luar jangkauan grid.');
        }

        // Grid Engine
        $startIndex = ($y - 1) * 5 + ($x - 1);
        $slotsPerPage = 40;

        $items = [];
        for ($i = 0; $i < $startIndex; $i++) {
            $items[] = null;
        }
        foreach ($data as $item) {
            $items[] = $item;
        }

        $pages = array_chunk($items, $slotsPerPage);

        $pdf = Pdf::loadView('admin.Feature.pdf_print', compact('pages'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('label_barang.pdf');
    }
}
