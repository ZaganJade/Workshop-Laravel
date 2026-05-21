<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * Controller untuk Studi Kasus 1: Cascading Select Wilayah Administrasi Indonesia.
 *
 * Sumber data: https://github.com/guzfirdaus/Wilayah-Administrasi-Indonesia
 * CSV disimpan di database/data/wilayah/
 *
 * Untuk performa, hasil parsing CSV di-cache (file villages.csv ~2.5MB).
 */
class WilayahCascadeController extends Controller
{
    /**
     * Standar format response untuk semua endpoint Ajax/Axios.
     */
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
     * Parse CSV menjadi array of [id, parent_id?, name].
     * Cache permanen, di-clear hanya jika file CSV diganti.
     */
    private function loadCsv(string $file, bool $hasParent): array
    {
        $cacheKey = 'wilayah.' . $file;

        return Cache::rememberForever($cacheKey, function () use ($file, $hasParent) {
            $path = database_path('data/wilayah/' . $file);

            if (!is_file($path)) {
                return [];
            }

            $rows = [];
            $handle = fopen($path, 'r');
            $header = fgetcsv($handle, 0, ';');

            while (($row = fgetcsv($handle, 0, ';')) !== false) {
                if ($hasParent) {
                    $rows[] = [
                        'id'        => $row[0] ?? '',
                        'parent_id' => $row[1] ?? '',
                        'name'      => $row[2] ?? '',
                    ];
                } else {
                    $rows[] = [
                        'id'   => $row[0] ?? '',
                        'name' => $row[1] ?? '',
                    ];
                }
            }
            fclose($handle);

            return $rows;
        });
    }

    public function provinsi()
    {
        $data = $this->loadCsv('provinces.csv', false);

        // Sort by name agar dropdown lebih ergonomis.
        usort($data, fn ($a, $b) => strcmp($a['name'], $b['name']));

        return $this->respond('success', 200, 'Provinsi berhasil dimuat', $data);
    }

    public function kota(Request $request)
    {
        $provinceId = (string) $request->input('province_id', '');
        if ($provinceId === '' || $provinceId === '0') {
            return $this->respond('error', 422, 'province_id wajib diisi', []);
        }

        $all = $this->loadCsv('regencies.csv', true);
        $filtered = array_values(array_filter($all, fn ($r) => $r['parent_id'] === $provinceId));
        usort($filtered, fn ($a, $b) => strcmp($a['name'], $b['name']));

        return $this->respond('success', 200, 'Kota berhasil dimuat', $filtered);
    }

    public function kecamatan(Request $request)
    {
        $regencyId = (string) $request->input('regency_id', '');
        if ($regencyId === '' || $regencyId === '0') {
            return $this->respond('error', 422, 'regency_id wajib diisi', []);
        }

        $all = $this->loadCsv('districts.csv', true);
        $filtered = array_values(array_filter($all, fn ($r) => $r['parent_id'] === $regencyId));
        usort($filtered, fn ($a, $b) => strcmp($a['name'], $b['name']));

        return $this->respond('success', 200, 'Kecamatan berhasil dimuat', $filtered);
    }

    public function kelurahan(Request $request)
    {
        $districtId = (string) $request->input('district_id', '');
        if ($districtId === '' || $districtId === '0') {
            return $this->respond('error', 422, 'district_id wajib diisi', []);
        }

        $all = $this->loadCsv('villages.csv', true);
        $filtered = array_values(array_filter($all, fn ($r) => $r['parent_id'] === $districtId));
        usort($filtered, fn ($a, $b) => strcmp($a['name'], $b['name']));

        return $this->respond('success', 200, 'Kelurahan berhasil dimuat', $filtered);
    }
}
