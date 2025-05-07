<?php

namespace App\Http\Controllers\UnitPelayanan\Operasi;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\OkSiteMarking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SiteMarkingController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/operasi');
    }


    private function formatDateForUrl($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Ambil data kunjungan
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        // Hitung umur pasien
        if ($dataMedis && $dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Cek apakah data kunjungan ditemukan
        if (!$dataMedis) {
            abort(404, 'Data kunjungan tidak ditemukan');
        }

        // Ambil riwayat site marking untuk pasien dan kunjungan spesifik
        $siteMarkings = OkSiteMarking::with(['creator', 'dokter'])
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('waktu_prosedure', 'desc')
            ->get();

        return view('unit-pelayanan.operasi.pelayanan.sitemarking.index', compact('dataMedis', 'kd_pasien', 'tgl_masuk', 'urut_masuk', 'siteMarkings'));
    }

    public function create($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $dokter = Dokter::where('status', 1)->get();

        // Menghitung umur
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Cek jenis kelamin pasien dan arahkan ke view yang sesuai
        return view('unit-pelayanan.operasi.pelayanan.sitemarking.create', compact('dataMedis', 'kd_pasien', 'tgl_masuk', 'urut_masuk', 'dokter'));
    }


    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // dd($request->all());

        DB::beginTransaction();

        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'kd_pasien' => 'required|string|max:255',
                'tgl_masuk' => 'required',
                'urut_masuk' => 'required|integer',
                'active_template' => 'required|string|max:255',
                'marking_data' => 'required',
                'waktu' => 'required',
                'prosedur_operasi' => 'required|string',
                'notes' => 'nullable|string',
                'tanda_tangan_dokter' => 'required',
                'tanda_tangan_pasien' => 'required',
                'confirmation' => 'required',
                'template_png_full_body' => 'nullable',
                'template_png_head_front_back' => 'nullable',
                'template_png_head_side' => 'nullable',
                'template_png_hand_dorsal' => 'nullable',
                'template_png_hand_palmar' => 'nullable',
                'template_png_foot' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Format tanggal
            $formatTglMasuk = date('Y-m-d', strtotime($tgl_masuk));
            $waktuProsedure = date('Y-m-d H:i:s', strtotime($request->waktu));

            // Persiapkan data untuk disimpan
            $data = [
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $formatTglMasuk,
                'urut_masuk' => $urut_masuk,
                'active_template' => $request->active_template,
                'marking_data' => $request->marking_data,
                'kd_dokter' => $request->ahli_bedah,
                'waktu_prosedure' => $waktuProsedure,
                'prosedure' => $request->prosedur_operasi,
                'notes' => $request->notes,
                'confirmation' => $request->has('confirmation') ? 1 : 0,
                'user_create' => auth()->user()->id,
            ];

            // Simpan tanda tangan dokter (konversi dari base64 ke file)
            if ($request->tanda_tangan_dokter) {
                // Hapus header base64 jika ada
                $imageData = $request->tanda_tangan_dokter;
                if (strpos($imageData, ';base64,') !== false) {
                    list(, $imageData) = explode(';base64,', $imageData);
                }
                $imageData = str_replace(' ', '+', $imageData);
                $imageData = base64_decode($imageData);

                // Buat nama file unik
                $filename = 'ttd_dokter_' . time() . '_' . uniqid() . '.png';
                $path = "uploads/operasi/site-marking/{$formatTglMasuk}/{$kd_pasien}/{$urut_masuk}";

                // Pastikan direktori ada
                if (!Storage::exists($path)) {
                    Storage::makeDirectory($path);
                }

                // Simpan gambar
                Storage::put($path . '/' . $filename, $imageData);

                // Simpan path ke database
                $data['tanda_tangan_dokter'] = $path . '/' . $filename;
            }

            // Simpan tanda tangan pasien (konversi dari base64 ke file)
            if ($request->tanda_tangan_pasien) {
                // Hapus header base64 jika ada
                $imageData = $request->tanda_tangan_pasien;
                if (strpos($imageData, ';base64,') !== false) {
                    list(, $imageData) = explode(';base64,', $imageData);
                }
                $imageData = str_replace(' ', '+', $imageData);
                $imageData = base64_decode($imageData);

                // Buat nama file unik
                $filename = 'ttd_pasien_' . time() . '_' . uniqid() . '.png';
                $path = "uploads/operasi/site-marking/{$formatTglMasuk}/{$kd_pasien}/{$urut_masuk}";

                // Pastikan direktori ada
                if (!Storage::exists($path)) {
                    Storage::makeDirectory($path);
                }

                // Simpan gambar
                Storage::put($path . '/' . $filename, $imageData);

                // Simpan path ke database
                $data['tanda_tangan_pasien'] = $path . '/' . $filename;
            }

            // BAGIAN BARU: Simpan gambar PNG untuk setiap template
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

            return redirect()->route('operasi.pelayanan.site-marking.index', [
                $kd_pasien,
                $formattedDate,
                $urut_masuk
            ])->with('success', 'Site Marking berhasil disimpan! Siap operasi!');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Ambil data pasien
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

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

        return view('unit-pelayanan.operasi.pelayanan.sitemarking.show', compact('dataMedis', 'siteMarking', 'dokter', 'markingData'));
    }


    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Ambil data pasien
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Ambil data site marking yang akan diedit
        $siteMarking = OkSiteMarking::with('dokter', 'creator')
            ->where('id', $id)
            ->first();

        if (!$siteMarking) {
            abort(404, 'Site marking not found');
        }

        // Ambil data dokter untuk dropdown
        $dokter = Dokter::where('status', 1)->get();

        return view('unit-pelayanan.operasi.pelayanan.sitemarking.edit', compact('dataMedis', 'siteMarking', 'kd_pasien', 'tgl_masuk', 'urut_masuk', 'dokter'));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'active_template' => 'required|string|max:255',
                'marking_data' => 'required',
                'waktu' => 'required',
                'prosedur_operasi' => 'required|string',
                'notes' => 'nullable|string',
                'tanda_tangan_dokter' => 'nullable',
                'tanda_tangan_pasien' => 'nullable',
                'confirmation' => 'required',
                'template_png_full_body' => 'nullable',
                'template_png_head_front_back' => 'nullable',
                'template_png_head_side' => 'nullable',
                'template_png_hand_dorsal' => 'nullable',
                'template_png_hand_palmar' => 'nullable',
                'template_png_foot' => 'nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // Format tanggal
            $formatTglMasuk = date('Y-m-d', strtotime($tgl_masuk));
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
            ];

            // Update tanda tangan dokter jika disediakan
            if ($request->tanda_tangan_dokter && strpos($request->tanda_tangan_dokter, 'data:image') === 0) {
                // Hapus header base64 jika ada
                $imageData = $request->tanda_tangan_dokter;
                if (strpos($imageData, ';base64,') !== false) {
                    list(, $imageData) = explode(';base64,', $imageData);
                }
                $imageData = str_replace(' ', '+', $imageData);
                $imageData = base64_decode($imageData);

                // Buat nama file unik
                $filename = 'ttd_dokter_' . time() . '_' . uniqid() . '.png';
                $path = "uploads/operasi/site-marking/{$formatTglMasuk}/{$kd_pasien}/{$urut_masuk}";

                // Pastikan direktori ada
                if (!Storage::exists($path)) {
                    Storage::makeDirectory($path);
                }

                // Hapus file tanda tangan lama jika ada
                if ($siteMarking->tanda_tangan_dokter && Storage::exists($siteMarking->tanda_tangan_dokter)) {
                    Storage::delete($siteMarking->tanda_tangan_dokter);
                }

                // Simpan gambar baru
                Storage::put($path . '/' . $filename, $imageData);

                // Simpan path ke database
                $data['tanda_tangan_dokter'] = $path . '/' . $filename;
            }

            // Update tanda tangan pasien jika disediakan
            if ($request->tanda_tangan_pasien && strpos($request->tanda_tangan_pasien, 'data:image') === 0) {
                // Hapus header base64 jika ada
                $imageData = $request->tanda_tangan_pasien;
                if (strpos($imageData, ';base64,') !== false) {
                    list(, $imageData) = explode(';base64,', $imageData);
                }
                $imageData = str_replace(' ', '+', $imageData);
                $imageData = base64_decode($imageData);

                // Buat nama file unik
                $filename = 'ttd_pasien_' . time() . '_' . uniqid() . '.png';
                $path = "uploads/operasi/site-marking/{$formatTglMasuk}/{$kd_pasien}/{$urut_masuk}";

                // Pastikan direktori ada
                if (!Storage::exists($path)) {
                    Storage::makeDirectory($path);
                }

                // Hapus file tanda tangan lama jika ada
                if ($siteMarking->tanda_tangan_pasien && Storage::exists($siteMarking->tanda_tangan_pasien)) {
                    Storage::delete($siteMarking->tanda_tangan_pasien);
                }

                // Simpan gambar baru
                Storage::put($path . '/' . $filename, $imageData);

                // Simpan path ke database
                $data['tanda_tangan_pasien'] = $path . '/' . $filename;
            }

            // BAGIAN BARU: Update gambar PNG untuk setiap template
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

            return redirect()->route('operasi.pelayanan.site-marking.index', [
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk
            ])->with('success', 'Site Marking berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating site marking: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

            return redirect()->route('operasi.pelayanan.site-marking.index', [
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk
            ])->with('success', 'Site Marking berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting site marking: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function print($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Ambil data pasien
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', 71)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Ambil data site marking
        $siteMarking = OkSiteMarking::with('dokter', 'creator')
            ->where('id', $id)
            ->first();

        if (!$siteMarking) {
            abort(404, 'Site marking not found');
        }

        // Parse data marking_images ke JSON
        $markingImages = json_decode($siteMarking->marking_images, true) ?? [];

        return view('unit-pelayanan.operasi.pelayanan.sitemarking.print', compact('dataMedis', 'siteMarking', 'markingImages'));
    }
}