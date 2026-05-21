<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class NfcMahasiswaController extends Controller
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

    public function index()
    {
        $mahasiswa = Mahasiswa::orderBy('nim')->get();

        return view('admin.nfc.mahasiswa', [
            'mahasiswa' => $mahasiswa,
        ]);
    }

    public function checkSerial(Request $request)
    {
        $request->validate(['serial' => 'required|string|max:50']);

        $serial = strtoupper(trim($request->input('serial')));
        $existing = Mahasiswa::where('nfc_serial', $serial)->first();

        if ($existing) {
            return $this->respond('success', 200, 'Serial sudah terpakai', [
                'available' => false,
                'mahasiswa' => [
                    'nim'   => $existing->nim,
                    'nama'  => $existing->nama,
                    'kelas' => $existing->kelas,
                ],
            ]);
        }

        return $this->respond('success', 200, 'Serial tersedia', [
            'available' => true,
            'mahasiswa' => null,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim'        => 'required|string|max:20|unique:mahasiswa,nim',
            'nama'       => 'required|string|max:100',
            'kelas'      => 'required|string|max:20',
            'nfc_serial' => 'nullable|string|max:50|unique:mahasiswa,nfc_serial',
        ]);

        $mahasiswa = Mahasiswa::create($validated);

        return $this->respond('success', 200, 'Mahasiswa berhasil ditambahkan', $mahasiswa);
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);

        $validated = $request->validate([
            'nim'        => 'required|string|max:20|unique:mahasiswa,nim,' . $id,
            'nama'       => 'required|string|max:100',
            'kelas'      => 'required|string|max:20',
            'nfc_serial' => 'nullable|string|max:50|unique:mahasiswa,nfc_serial,' . $id,
        ]);

        $mahasiswa->update($validated);

        return $this->respond('success', 200, 'Mahasiswa berhasil diperbarui', $mahasiswa);
    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->delete();

        return $this->respond('success', 200, 'Mahasiswa berhasil dihapus', null);
    }
}
