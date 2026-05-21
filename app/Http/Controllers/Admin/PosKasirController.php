<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controller untuk Studi Kasus 2: POS Kasir.
 *
 * Endpoint:
 *  - GET  cari/{kode}   -> cari barang berdasarkan id_barang
 *  - POST simpan        -> simpan transaksi (header + detail) dalam DB transaction
 */
class PosKasirController extends Controller
{
    private function respond(string $status, int $code, string $message, $data = null)
    {
        return response()->json([
            'status'  => $status,
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
        ]);
    }

    /**
     * Cari barang berdasarkan kode (id_barang).
     */
    public function cari(string $kode)
    {
        $barang = Barang::where('id_barang', $kode)->first();

        if (!$barang) {
            return $this->respond('error', 404, 'Barang tidak ditemukan', null);
        }

        return $this->respond('success', 200, 'Barang ditemukan', [
            'id_barang' => $barang->id_barang,
            'nama'      => $barang->nama,
            'harga'     => (int) $barang->harga,
        ]);
    }

    /**
     * Simpan transaksi kasir.
     *
     * Payload:
     *  - items: array of {id_barang, nama, harga, jumlah, subtotal}
     *  - total: int
     */
    public function simpan(Request $request)
    {
        $validated = $request->validate([
            'total'                 => 'required|integer|min:1',
            'items'                 => 'required|array|min:1',
            'items.*.id_barang'     => 'required|string|exists:barang,id_barang',
            'items.*.nama'          => 'required|string',
            'items.*.harga'         => 'required|integer|min:0',
            'items.*.jumlah'        => 'required|integer|min:1',
            'items.*.subtotal'      => 'required|integer|min:0',
        ]);

        try {
            $idtransaksi = DB::transaction(function () use ($validated) {
                $idtransaksi = DB::table('transaksi_kasir')->insertGetId([
                    'total'      => $validated['total'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $rows = array_map(fn ($item) => [
                    'idtransaksi' => $idtransaksi,
                    'id_barang'   => $item['id_barang'],
                    'nama'        => $item['nama'],
                    'harga'       => $item['harga'],
                    'jumlah'      => $item['jumlah'],
                    'subtotal'    => $item['subtotal'],
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ], $validated['items']);

                DB::table('transaksi_kasir_detail')->insert($rows);

                return $idtransaksi;
            });

            return $this->respond('success', 200, 'Transaksi berhasil disimpan', [
                'idtransaksi' => $idtransaksi,
                'total'       => $validated['total'],
            ]);
        } catch (\Throwable $e) {
            return $this->respond('error', 500, 'Gagal menyimpan transaksi: ' . $e->getMessage(), null);
        }
    }
}
