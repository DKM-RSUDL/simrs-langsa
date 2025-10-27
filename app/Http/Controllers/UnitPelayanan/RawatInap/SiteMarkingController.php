<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\OkSiteMarking;
use App\Models\OrderOK;
use App\Services\BaseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SiteMarkingController extends Controller
{
    private $baseService;
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->baseService = new BaseService();
    }


    private function formatDateForUrl($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    private function getCommonData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op)
    {
        // Ambil data kunjungan
        $dataMedis = $this->baseService->getDataMedis($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (!$dataMedis) {
            abort(404, 'Data medis tidak ditemukan.');
        }

        $operasi = OrderOK::where('kd_kasir', $dataMedis->kd_kasir)
            ->where('no_transaksi', $dataMedis->no_transaksi)
            ->where('tgl_op', $tgl_op)
            ->where('jam_op', $jam_op)
            ->first();
        if (!$operasi) {
            abort(404, 'Data operasi tidak ditemukan');
        }

        // get kunjungan ok
        $kunjunganOK = $this->baseService->getDataMedisbyTransaksi($operasi->kd_kasir_ok, $operasi->no_transaksi_ok);
        if (!$kunjunganOK) {
            abort(404, 'Data kunjungan OK tidak ditemukan');
        }

        return compact('dataMedis', 'operasi', 'kunjunganOK');
    }

    public function index($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op)
    {
        extract($this->getCommonData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op));

        // Ambil riwayat site marking untuk pasien dan kunjungan spesifik
        $siteMarkings = OkSiteMarking::with(['creator', 'dokter'])
            ->where('kd_pasien', $kunjunganOK->kd_pasien)
            ->where('tgl_masuk', $kunjunganOK->tgl_masuk)
            ->where('urut_masuk', $kunjunganOK->urut_masuk)
            ->orderBy('waktu_prosedure', 'desc')
            ->get();


        return view('unit-pelayanan.rawat-inap.pelayanan.order.operasi.sitemarking.index', compact('dataMedis', 'siteMarkings', 'operasi'));
    }

    public function create($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op)
    {
        extract($this->getCommonData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op));

        $dokter = Dokter::where('status', 1)->get();

        // Menghitung umur
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Cek jenis kelamin pasien dan arahkan ke view yang sesuai
        return view('unit-pelayanan.rawat-inap.pelayanan.order.operasi.sitemarking.create', compact('dataMedis', 'kd_pasien', 'tgl_masuk', 'urut_masuk', 'dokter', 'operasi'));
    }


    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op)
    {
        DB::beginTransaction();

        try {
            extract($this->getCommonData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op));

            // Format tanggal
            $formatTglMasuk = date('Y-m-d', strtotime($kunjunganOK->tgl_masuk));
            $waktuProsedure = date('Y-m-d H:i:s', strtotime($request->waktu));

            // Persiapkan data untuk disimpan
            $data = [
                'kd_pasien' => $kunjunganOK->kd_pasien,
                'tgl_masuk' => $formatTglMasuk,
                'urut_masuk' => $kunjunganOK->urut_masuk,
                'active_template' => $request->active_template,
                'marking_data' => $request->marking_data,
                'kd_dokter' => $request->ahli_bedah,
                'waktu_prosedure' => $waktuProsedure,
                'prosedure' => $request->prosedur_operasi,
                'notes' => $request->notes,
                'confirmation' => $request->has('confirmation') ? 1 : 0,
                'user_create' => auth()->user()->id,
                'responsible_person' => $request->responsible_person,
                'patient_name' => $request->responsible_person === 'pasien' ? $request->patient_name : null,
                'family_name' => $request->responsible_person === 'keluarga' ? $request->family_name : null,
                'family_relationship' => $request->responsible_person === 'keluarga' ? $request->family_relationship : null,
                'family_address' => $request->responsible_person === 'keluarga' ? $request->family_address : null,
            ];

            // Simpan gambar PNG untuk setiap template
            $markingPath = "uploads/operasi/site-marking/{$formatTglMasuk}/{$kd_pasien}/{$urut_masuk}/marking";

            // Pastikan direktori ada
            if (!Storage::exists($markingPath)) {
                Storage::makeDirectory($markingPath);
            }

            // Daftar template yang akan disimpan
            $templateNames = [
                'full_body',
                'head_front_back',
                'head_side',
                'hand_dorsal',
                'hand_palmar',
                'foot'
            ];

            // Array untuk menyimpan path gambar marking
            $markingImages = [];

            // Simpan gambar PNG untuk setiap template
            foreach ($templateNames as $template) {
                $inputName = 'template_png_' . $template;

                if ($request->has($inputName) && !empty($request->$inputName)) {
                    // Hapus header base64 jika ada
                    $imageData = $request->$inputName;
                    if (strpos($imageData, ';base64,') !== false) {
                        list(, $imageData) = explode(';base64,', $imageData);
                    }
                    $imageData = str_replace(' ', '+', $imageData);
                    $imageData = base64_decode($imageData);

                    // Buat nama file unik
                    $filename = 'marking_' . str_replace('_', '-', $template) . '_' . time() . '_' . uniqid() . '.png';

                    // Simpan gambar
                    Storage::put($markingPath . '/' . $filename, $imageData);

                    // Tambahkan path ke array
                    $markingImages[str_replace('_', '-', $template)] = $markingPath . '/' . $filename;
                }
            }

            // Simpan data marking images ke database dalam format JSON
            $data['marking_images'] = json_encode($markingImages);

            // Simpan data ke database
            OkSiteMarking::create($data);
            $formattedDate = $this->formatDateForUrl($tgl_masuk);

            DB::commit();

            return redirect()->route('rawat-inap.operasi.site-marking.index', [
                $kd_unit,
                $kd_pasien,
                date('Y-m-d', strtotime($tgl_masuk)),
                $urut_masuk,
                $tgl_op,
                $jam_op,
            ])->with('success', 'Site Marking berhasil disimpan! Siap operasi!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op, $id)
    {
        extract($this->getCommonData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op));

        // Ambil data site marking
        $siteMarking = OkSiteMarking::with('dokter', 'creator')
            ->where('id', $id)
            ->first();

        if (!$siteMarking) {
            abort(404, 'Site marking not found');
        }

        // Ambil data dokter untuk dropdown jika diperlukan
        $dokter = Dokter::where('status', 1)->get();

        // Parsedkan data marking ke JSON
        $markingData = json_decode($siteMarking->marking_data, true);

        return view('unit-pelayanan.rawat-inap.pelayanan.order.operasi.sitemarking.show', compact('dataMedis', 'siteMarking', 'dokter', 'markingData', 'operasi'));
    }


    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op, $id)
    {
        extract($this->getCommonData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op));

        // Ambil data site marking yang akan diedit
        $siteMarking = OkSiteMarking::with('dokter', 'creator')
            ->where('id', $id)
            ->first();

        if (!$siteMarking) {
            abort(404, 'Site marking not found');
        }

        // Ambil data dokter untuk dropdown
        $dokter = Dokter::where('status', 1)->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.order.operasi.sitemarking.edit', compact('dataMedis', 'siteMarking', 'kd_pasien', 'tgl_masuk', 'urut_masuk', 'dokter', 'tgl_op', 'jam_op', 'operasi'));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op, $id)
    {
        DB::beginTransaction();

        try {
            extract($this->getCommonData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op));

            // Format tanggal
            $formatTglMasuk = date('Y-m-d', strtotime($kunjunganOK->tgl_masuk));
            $waktuProsedure = date('Y-m-d H:i:s', strtotime($request->waktu));

            // Cari data site marking yang akan diupdate
            $siteMarking = OkSiteMarking::findOrFail($id);

            // Persiapkan data untuk diupdate
            $data = [
                'active_template' => $request->active_template,
                'marking_data' => $request->marking_data,
                'kd_dokter' => $request->ahli_bedah,
                'waktu_prosedure' => $waktuProsedure,
                'prosedure' => $request->prosedur_operasi,
                'notes' => $request->notes,
                'confirmation' => $request->has('confirmation') ? 1 : 0,
                'user_update' => auth()->user()->id,
                'responsible_person' => $request->responsible_person,
                'patient_name' => $request->responsible_person === 'pasien' ? $request->patient_name : null,
                'family_name' => $request->responsible_person === 'keluarga' ? $request->family_name : null,
                'family_relationship' => $request->responsible_person === 'keluarga' ? $request->family_relationship : null,
                'family_address' => $request->responsible_person === 'keluarga' ? $request->family_address : null,
            ];

            // Update gambar PNG untuk setiap template
            $markingPath = "Uploads/operasi/site-marking/{$formatTglMasuk}/{$kd_pasien}/{$urut_masuk}/marking";

            // Pastikan direktori ada
            if (!Storage::exists($markingPath)) {
                Storage::makeDirectory($markingPath);
            }

            // Daftar template yang akan disimpan
            $templateNames = [
                'full_body',
                'head_front_back',
                'head_side',
                'hand_dorsal',
                'hand_palmar',
                'foot'
            ];

            // Array untuk menyimpan path gambar marking
            $markingImages = [];

            // Ambil data marking_images yang sudah ada jika tersedia
            $existingMarkingImages = [];
            if ($siteMarking->marking_images) {
                $existingMarkingImages = json_decode($siteMarking->marking_images, true) ?: [];
            }

            // Simpan gambar PNG untuk setiap template
            foreach ($templateNames as $template) {
                $inputName = 'template_png_' . $template;

                if ($request->has($inputName) && !empty($request->$inputName)) {
                    // Hapus file lama jika ada
                    $templateKey = str_replace('_', '-', $template);
                    if (isset($existingMarkingImages[$templateKey]) && Storage::exists($existingMarkingImages[$templateKey])) {
                        Storage::delete($existingMarkingImages[$templateKey]);
                    }

                    // Hapus header base64 jika ada
                    $imageData = $request->$inputName;
                    if (strpos($imageData, ';base64,') !== false) {
                        list(, $imageData) = explode(';base64,', $imageData);
                    }
                    $imageData = str_replace(' ', '+', $imageData);
                    $imageData = base64_decode($imageData);

                    // Buat nama file unik
                    $filename = 'marking_' . str_replace('_', '-', $template) . '_' . time() . '_' . uniqid() . '.png';

                    // Simpan gambar
                    Storage::put($markingPath . '/' . $filename, $imageData);

                    // Tambahkan path ke array
                    $markingImages[str_replace('_', '-', $template)] = $markingPath . '/' . $filename;
                } else {
                    // Jika tidak ada gambar baru, pertahankan gambar yang sudah ada
                    $templateKey = str_replace('_', '-', $template);
                    if (isset($existingMarkingImages[$templateKey])) {
                        $markingImages[$templateKey] = $existingMarkingImages[$templateKey];
                    }
                }
            }

            // Simpan data marking images ke database dalam format JSON
            $data['marking_images'] = json_encode($markingImages);

            // Update data di database
            $siteMarking->update($data);

            DB::commit();

            return redirect()->route('rawat-inap.operasi.site-marking.index', [
                $kd_unit,
                $kd_pasien,
                date('Y-m-d', strtotime($tgl_masuk)),
                $urut_masuk,
                $tgl_op,
                $jam_op,
            ])->with('success', 'Site Marking berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating site marking: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op, $id)
    {
        DB::beginTransaction();

        try {
            // Cari data site marking yang akan dihapus
            $siteMarking = OkSiteMarking::findOrFail($id);

            // Hapus file tanda tangan dokter jika ada
            if ($siteMarking->tanda_tangan_dokter && Storage::exists($siteMarking->tanda_tangan_dokter)) {
                Storage::delete($siteMarking->tanda_tangan_dokter);
            }

            // Hapus file tanda tangan pasien jika ada
            if ($siteMarking->tanda_tangan_pasien && Storage::exists($siteMarking->tanda_tangan_pasien)) {
                Storage::delete($siteMarking->tanda_tangan_pasien);
            }

            // Hapus data dari database
            $siteMarking->delete();

            DB::commit();

            return redirect()->route('rawat-inap.operasi.site-marking.index', [
                $kd_unit,
                $kd_pasien,
                date('Y-m-d', strtotime($tgl_masuk)),
                $urut_masuk,
                $tgl_op,
                $jam_op,
            ])->with('success', 'Site Marking berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting site marking: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function print($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op, $id)
    {
        extract($this->getCommonData($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $tgl_op, $jam_op));

        // Ambil data site marking
        $siteMarking = OkSiteMarking::with('dokter', 'creator')
            ->where('id', $id)
            ->first();

        if (!$siteMarking) {
            abort(404, 'Site marking not found');
        }

        // Parse data marking_images ke JSON
        $markingImages = json_decode($siteMarking->marking_images, true) ?? [];

        return view('unit-pelayanan.rawat-inap.pelayanan.order.operasi.sitemarking.print', compact('dataMedis', 'siteMarking', 'markingImages', 'operasi'));
    }
}
