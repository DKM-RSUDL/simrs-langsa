<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\RadHasil;

class RadiologyFileService
{
    protected string $mountPath;
    protected ?string $connectionName;

    public function __construct(?string $mountPath = null, ?string $connectionName = null)
    {
        $rawPath = $mountPath ?? (string) config('radiology.mount_path', '');

        // Normalize path: convert // to \\ for Windows UNC
        if (substr($rawPath, 0, 2) === '//') {
            // Forward slash UNC format -> convert to backslash
            $rawPath = '\\\\' . substr($rawPath, 2);
            $rawPath = str_replace('/', '\\', $rawPath);
        }

        $this->mountPath = $rawPath;
        $this->connectionName = $connectionName ?? config('radiology.connection');
    }

    /**
     * Ambil nama file dari field FILE di RAD_HASIL yang berisi UNC path.
     */
    public function extractFileName($filePath): ?string
    {
        if (!is_string($filePath) || $filePath === '') {
            return null;
        }

        // Ubah backslash ke slash biar basename() aman
        $normalized = str_replace('\\', '/', $filePath);

        return basename($normalized);
    }

    /**
     * Build path absolut di server:
     * {mount_path}/ASURANSI/{YYYY-MM}/Radiologi/{fileName}
     *
     * Support untuk:
     * - Windows UNC: \\192.168.99.4\share\...
     * - Windows mapped drive: Z:\...
     * - Linux mount: /mnt/radiology/...
     */
    public function buildFilePath(string $fileName, string $tanggal): string
    {
        $monthPath = Carbon::parse($tanggal)->format('Y-m');

        // Normalize base path
        $base = rtrim($this->mountPath, '\\/');

        // Detect if UNC path (starts with \\)
        $isUNC = substr($base, 0, 2) === '\\\\';

        // Detect if Windows mapped drive (e.g., Z:)
        $isMappedDrive = preg_match('/^[A-Z]:$/i', $base);


        // Build path with appropriate separator
        if ($isUNC || $isMappedDrive || DIRECTORY_SEPARATOR === '\\') {
            // Windows style - use backslash
            return $base
                . '\\ASURANSI'
                . '\\' . $monthPath
                . '\\Radiologi'
                . '\\' . $fileName;
        } else {
            // Unix/Linux style - use forward slash
            return $base
                . '/ASURANSI'
                . '/' . $monthPath
                . '/Radiologi'
                . '/' . $fileName;
        }
    }

    public function fileExists(string $path): bool
    {
        // Clear cache untuk memastikan hasil terbaru
        clearstatcache(true, $path);
        return file_exists($path) && is_file($path);
    }

    /**
     * Validasi bahwa file memang milik pasien & kunjungan ini.
     */
    public function validateFileOwnership(
        string $fileName,
        string $kdPasien,
        string $tanggal,
        ?string $kdUnit = null,
        ?int $urutMasuk = null
    ): bool {
        try {
            // Build Eloquent query using the RadHasil model
            $query = RadHasil::query();

            if (!empty($this->connectionName)) {
                $query = RadHasil::on($this->connectionName);
            }

            $query->where('kd_pasien', $kdPasien)
                ->whereDate('tgl_masuk', $tanggal)
                ->where('file', 'like', '%' . $fileName . '%');

            if ($kdUnit !== null) {
                $query->where('kd_unit', $kdUnit);
            }

            if ($urutMasuk !== null) {
                $query->where('urut_masuk', $urutMasuk);
            }

            $total = (int) $query->count();
        } catch (\Exception $e) {
            Log::warning('RadiologyFileService: validateFileOwnership query failed', ['err' => $e->getMessage()]);
            return false;
        }

        if ($total === 0) {
            Log::warning('RadiologyFileService: validateFileOwnership failed', [
                'file'       => $fileName,
                'kd_pasien'  => $kdPasien,
                'tanggal'    => $tanggal,
                'kd_unit'    => $kdUnit,
                'urut_masuk' => $urutMasuk,
            ]);
        }

        return $total > 0;
    }

    public function isWithinMount(string $path): bool
    {
        $realPath = realpath($path);
        $basePath = realpath($this->mountPath);

        if ($realPath === false || $basePath === false) {
            Log::warning('RadiologyFileService: realpath failed', [
                'path' => $path,
                'mount' => $this->mountPath,
                'realPath' => $realPath,
                'basePath' => $basePath
            ]);
            return false;
        }

        // Normalize untuk comparison
        $realPath = rtrim(str_replace('\\', '/', $realPath), '/');
        $basePath = rtrim(str_replace('\\', '/', $basePath), '/');

        return str_starts_with($realPath, $basePath);
    }

    /**
     * Cari path asli dari kolom FILE di tabel RAD_HASIL berdasarkan nama file dan kunjungan.
     * Mengembalikan string path (UNC/absolute) atau null jika tidak ditemukan.
     */
    public function findOriginalFilePath(string $fileName, string $kdPasien, string $tanggal, ?string $kdUnit = null, ?int $urutMasuk = null): ?string
    {
        try {
            $query = RadHasil::query();

            if (!empty($this->connectionName)) {
                $query = RadHasil::on($this->connectionName);
            }

            $query->where('kd_pasien', $kdPasien)
                ->whereDate('tgl_masuk', $tanggal)
                ->where('file', 'like', '%' . $fileName . '%');

            if ($kdUnit !== null) {
                $query->where('kd_unit', $kdUnit);
            }
            if ($urutMasuk !== null) {
                $query->where('urut_masuk', $urutMasuk);
            }

            $row = $query->orderByDesc('tgl_masuk')->first(['file']);
            if (!$row) return null;

            $raw = $row->file ?? $row->FILE ?? null;
            if (!is_string($raw) || $raw === '') return null;

            // Normalize separators: keep leading UNC backslashes
            $raw = str_replace('/', DIRECTORY_SEPARATOR, $raw);
            $raw = preg_replace('~\\+~', '\\', $raw);

            return $raw;
        } catch (\Exception $e) {
            Log::warning('RadiologyFileService: findOriginalFilePath failed', ['err' => $e->getMessage()]);
            return null;
        }
    }
}
