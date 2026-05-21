<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\NfcAbsensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NfcController extends Controller
{
    private function respond(string $status, int $code, string $message, $data = null)
    {
        return response()->json([
            'status'  => $status,
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    public function scanPage()
    {
        return view('admin.nfc.absensi');
    }

    /**
     * Logika utama scan absensi.
     * - Cari mahasiswa berdasarkan nfc_serial
     * - Tentukan tipe (masuk/pulang) dari event terakhir hari ini
     * - Simpan event baru, return data lengkap
     */
    public function scan(Request $request)
    {
        $validated = $request->validate([
            'nfc_serial' => 'required|string|max:50',
        ]);

        $serial = strtoupper(trim($validated['nfc_serial']));

        $mahasiswa = Mahasiswa::where('nfc_serial', $serial)->first();
        if (!$mahasiswa) {
            return $this->respond('error', 404, 'Kartu belum terdaftar', [
                'nfc_serial' => $serial,
            ]);
        }

        $last = NfcAbsensi::where('mahasiswa_id', $mahasiswa->id)
            ->whereDate('waktu', now()->toDateString())
            ->orderBy('waktu', 'desc')
            ->first();

        // Tentukan tipe scan ini
        if ($last === null || $last->tipe === 'pulang') {
            $tipe = 'masuk';
        } else {
            // last->tipe === 'masuk'
            $tipe = 'pulang';
        }

        $absensi = DB::transaction(function () use ($mahasiswa, $tipe) {
            return NfcAbsensi::create([
                'mahasiswa_id' => $mahasiswa->id,
                'tipe'         => $tipe,
                'waktu'        => now(),
            ]);
        });

        // Hitung durasi jika tipe = pulang
        $durasi = null;
        if ($tipe === 'pulang' && $last) {
            $durasi = $this->formatDurasi($last->waktu, $absensi->waktu);
        }

        $message = $tipe === 'masuk'
            ? 'Absen masuk berhasil'
            : 'Absen pulang berhasil';

        return $this->respond('success', 200, $message, [
            'tipe'      => $tipe,
            'mahasiswa' => [
                'id'    => $mahasiswa->id,
                'nim'   => $mahasiswa->nim,
                'nama'  => $mahasiswa->nama,
                'kelas' => $mahasiswa->kelas,
            ],
            'waktu'  => $absensi->waktu->format('Y-m-d H:i:s'),
            'jam'    => $absensi->waktu->format('H:i'),
            'durasi' => $durasi,
        ]);
    }

    /**
     * Feed 10 absensi terakhir hari ini (untuk auto-refresh halaman scan).
     */
    public function feed()
    {
        $rows = NfcAbsensi::with('mahasiswa')
            ->whereDate('waktu', now()->toDateString())
            ->orderBy('waktu', 'desc')
            ->limit(10)
            ->get();

        $data = $rows->map(function ($row) {
            return [
                'id'    => $row->id,
                'tipe'  => $row->tipe,
                'jam'   => $row->waktu->format('H:i'),
                'mahasiswa' => [
                    'nim'   => $row->mahasiswa->nim,
                    'nama'  => $row->mahasiswa->nama,
                    'kelas' => $row->mahasiswa->kelas,
                ],
            ];
        });

        return $this->respond('success', 200, 'Feed berhasil', $data);
    }

    public function riwayat()
    {
        $mahasiswaList = Mahasiswa::orderBy('nim')->get(['id', 'nim', 'nama', 'kelas']);
        return view('admin.nfc.riwayat', [
            'mahasiswaList' => $mahasiswaList,
        ]);
    }

    /**
     * Data riwayat dengan pasangan masuk/pulang per siklus.
     */
    public function riwayatData(Request $request)
    {
        $validated = $request->validate([
            'tanggal'      => 'nullable|date',
            'mahasiswa_id' => 'nullable|integer|exists:mahasiswa,id',
        ]);

        $tanggal = $validated['tanggal'] ?? now()->toDateString();

        $query = NfcAbsensi::with('mahasiswa')
            ->whereDate('waktu', $tanggal)
            ->orderBy('mahasiswa_id')
            ->orderBy('waktu', 'asc');

        if (!empty($validated['mahasiswa_id'])) {
            $query->where('mahasiswa_id', $validated['mahasiswa_id']);
        }

        $rows = $query->get();

        // Group by mahasiswa_id
        $grouped = $rows->groupBy('mahasiswa_id');
        $result = [];

        foreach ($grouped as $mahasiswaId => $events) {
            $mhs = $events->first()->mahasiswa;
            $cycles = [];
            $eventsArr = $events->values();
            $cycleNum = 1;

            for ($i = 0; $i < $eventsArr->count(); $i += 2) {
                $masuk  = $eventsArr[$i] ?? null;
                $pulang = $eventsArr[$i + 1] ?? null;

                // Skip jika event pertama bukan masuk (data anomali, tidak diharapkan)
                if ($masuk && $masuk->tipe !== 'masuk') {
                    continue;
                }

                $cycles[] = [
                    'ke'     => $cycleNum,
                    'masuk'  => $masuk ? $masuk->waktu->format('H:i') : null,
                    'pulang' => ($pulang && $pulang->tipe === 'pulang') ? $pulang->waktu->format('H:i') : null,
                    'durasi' => ($pulang && $pulang->tipe === 'pulang')
                        ? $this->formatDurasi($masuk->waktu, $pulang->waktu)
                        : null,
                ];
                $cycleNum++;
            }

            $result[] = [
                'tanggal'   => $tanggal,
                'mahasiswa' => [
                    'nim'   => $mhs->nim,
                    'nama'  => $mhs->nama,
                    'kelas' => $mhs->kelas,
                ],
                'cycles' => $cycles,
            ];
        }

        return $this->respond('success', 200, 'Riwayat berhasil', $result);
    }

    /**
     * Format durasi antara 2 Carbon dalam string "X jam Y menit".
     */
    private function formatDurasi(Carbon $start, Carbon $end): string
    {
        $diffMinutes = $start->diffInMinutes($end);
        $jam = intdiv($diffMinutes, 60);
        $menit = $diffMinutes % 60;

        if ($jam === 0) {
            return $menit . ' menit';
        }
        return $jam . ' jam ' . $menit . ' menit';
    }
}
