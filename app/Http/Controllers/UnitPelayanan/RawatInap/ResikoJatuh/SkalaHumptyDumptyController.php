<?php

namespace App\Http\Controllers\UnitPelayanan\RawatInap\ResikoJatuh;

use App\Http\Controllers\Controller;
use App\Models\Kunjungan;
use App\Models\RmeSkalaHumptyDumpty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SkalaHumptyDumptyController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
    }

    public function index(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Query data Humpty Dumpty dengan filter
        $query = RmeSkalaHumptyDumpty::with('userCreated')
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk);

        // Filter berdasarkan pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('shift', 'like', "%{$search}%")
                    ->orWhere('kategori_risiko', 'like', "%{$search}%")
                    ->orWhere('total_skor', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('tanggal_implementasi', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('tanggal_implementasi', '<=', $request->sampai_tanggal);
        }

        // Urutkan berdasarkan tanggal terbaru
        $dataHumptyDumpty = $query->orderBy('tanggal_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->get();

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-humpty-dumpty.index', compact(
            'dataMedis',
            'dataHumptyDumpty'
        ));
    }

    public function create($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Ambil data penilaian terakhir yang valid untuk menentukan apakah penilaian perlu ditampilkan
        $lastAssessment = RmeSkalaHumptyDumpty::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('tanggal_implementasi', 'desc')
            ->orderBy('jam_implementasi', 'desc')
            ->first();

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-humpty-dumpty.create', compact(
            'dataMedis',
            'lastAssessment'
        ));
    }

    public function store(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Validasi input
        $request->validate([
            'tanggal_implementasi' => 'required|date',
            'jam_implementasi' => 'required',
            'shift' => 'required|in:PG,SI,ML'
        ]);

        DB::beginTransaction();

        try {
            // Validasi duplikasi tanggal dan shift
            $existingData = RmeSkalaHumptyDumpty::where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->where('tanggal_implementasi', $request->tanggal_implementasi)
                ->where('shift', $request->shift)
                ->first();

            if ($existingData) {
                return back()->with('error', 'Data dengan tanggal ' . date('d/m/Y', strtotime($request->tanggal_implementasi)) . ' dan shift ' . ucfirst($request->shift) . ' sudah ada!')
                    ->withInput();
            }

            // Siapkan data untuk disimpan
            $data = [
                'kd_pasien' => $kd_pasien,
                'kd_unit' => $kd_unit,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
                'user_created' => Auth::id(),
                'tanggal_implementasi' => $request->tanggal_implementasi,
                'jam_implementasi' => $request->jam_implementasi,
                'shift' => $request->shift,
            ];

            // Jika membuat penilaian baru (checkbox dicentang)
            if ($request->use_existing_assessment == '0') {
                // Hitung total skor dari input penilaian baru
                $totalSkor = (int)$request->usia +
                    (int)$request->jenis_kelamin +
                    (int)$request->diagnosis +
                    (int)$request->gangguan_kognitif +
                    (int)$request->faktor_lingkungan +
                    (int)$request->pembedahan_sedasi +
                    (int)$request->penggunaan_medikamentosa;

                // Tentukan kategori risiko
                if ($totalSkor >= 6 && $totalSkor <= 11) {
                    $kategoriRisiko = 'Risiko Rendah';
                } elseif ($totalSkor >= 12) {
                    $kategoriRisiko = 'Risiko Tinggi';
                } else {
                    $kategoriRisiko = 'Skor Tidak Valid';
                }

                $data['usia'] = (int)$request->usia;
                $data['jenis_kelamin'] = (int)$request->jenis_kelamin;
                $data['diagnosis'] = (int)$request->diagnosis;
                $data['gangguan_kognitif'] = (int)$request->gangguan_kognitif;
                $data['faktor_lingkungan'] = (int)$request->faktor_lingkungan;
                $data['pembedahan_sedasi'] = (int)$request->pembedahan_sedasi;
                $data['penggunaan_medikamentosa'] = (int)$request->penggunaan_medikamentosa;
                $data['total_skor'] = $totalSkor;
                $data['kategori_risiko'] = $kategoriRisiko;
            } else {
                // Gunakan data existing atau data terakhir yang valid
                if ($request->has('existing_usia')) {
                    // Gunakan data dari hidden input (existing)
                    $data['usia'] = $request->existing_usia;
                    $data['jenis_kelamin'] = $request->existing_jenis_kelamin;
                    $data['diagnosis'] = $request->existing_diagnosis;
                    $data['gangguan_kognitif'] = $request->existing_gangguan_kognitif;
                    $data['faktor_lingkungan'] = $request->existing_faktor_lingkungan;
                    $data['pembedahan_sedasi'] = $request->existing_pembedahan_sedasi;
                    $data['penggunaan_medikamentosa'] = $request->existing_penggunaan_medikamentosa;
                    $data['total_skor'] = $request->existing_total_skor;
                    $data['kategori_risiko'] = $request->existing_kategori_risiko;
                } else {
                    // Fallback: Gunakan data terakhir yang valid
                    $lastAssessment = RmeSkalaHumptyDumpty::where('kd_pasien', $kd_pasien)
                        ->where('kd_unit', $kd_unit)
                        ->whereDate('tgl_masuk', $tgl_masuk)
                        ->where('urut_masuk', $urut_masuk)
                        ->whereNotNull('usia')
                        ->whereNotNull('jenis_kelamin')
                        ->whereNotNull('diagnosis')
                        ->whereNotNull('gangguan_kognitif')
                        ->whereNotNull('faktor_lingkungan')
                        ->whereNotNull('pembedahan_sedasi')
                        ->whereNotNull('penggunaan_medikamentosa')
                        ->where('total_skor', '>', 0)
                        ->orderBy('tanggal_implementasi', 'desc')
                        ->orderBy('jam_implementasi', 'desc')
                        ->first();

                    if ($lastAssessment) {
                        $data['usia'] = $lastAssessment->usia;
                        $data['jenis_kelamin'] = $lastAssessment->jenis_kelamin;
                        $data['diagnosis'] = $lastAssessment->diagnosis;
                        $data['gangguan_kognitif'] = $lastAssessment->gangguan_kognitif;
                        $data['faktor_lingkungan'] = $lastAssessment->faktor_lingkungan;
                        $data['pembedahan_sedasi'] = $lastAssessment->pembedahan_sedasi;
                        $data['penggunaan_medikamentosa'] = $lastAssessment->penggunaan_medikamentosa;
                        $data['total_skor'] = $lastAssessment->total_skor;
                        $data['kategori_risiko'] = $lastAssessment->kategori_risiko;
                    }
                }
            }

            // Tambahkan intervensi berdasarkan kategori risiko
            if (isset($data['kategori_risiko'])) {
                // Reset semua intervensi
                $interventionFields = [
                    'observasi_ambulasi',
                    'orientasi_kamar_mandi',
                    'orientasi_bertahap',
                    'tempatkan_bel',
                    'instruksi_bantuan',
                    'pagar_pengaman',
                    'tempat_tidur_rendah',
                    'edukasi_perilaku',
                    'monitor_berkala',
                    'anjuran_kaus_kaki',
                    'lantai_antislip',
                    'semua_intervensi_rendah',
                    'gelang_kuning',
                    'pasang_gambar',
                    'tanda_daftar_nama',
                    'pertimbangkan_obat',
                    'alat_bantu_jalan',
                    'pintu_terbuka',
                    'jangan_tinggalkan',
                    'dekat_nurse_station',
                    'bed_posisi_rendah',
                    'edukasi_keluarga'
                ];

                foreach ($interventionFields as $field) {
                    $data[$field] = 0;
                }

                // Set intervensi sesuai kategori dan input
                if ($data['kategori_risiko'] == 'Risiko Rendah') {
                    $lowRiskFields = [
                        'observasi_ambulasi',
                        'orientasi_kamar_mandi',
                        'orientasi_bertahap',
                        'tempatkan_bel',
                        'instruksi_bantuan',
                        'pagar_pengaman',
                        'tempat_tidur_rendah',
                        'edukasi_perilaku',
                        'monitor_berkala',
                        'anjuran_kaus_kaki',
                        'lantai_antislip'
                    ];

                    foreach ($lowRiskFields as $field) {
                        $data[$field] = $request->has($field) ? 1 : 0;
                    }
                }

                if ($data['kategori_risiko'] == 'Risiko Tinggi') {
                    $highRiskFields = [
                        'semua_intervensi_rendah',
                        'gelang_kuning',
                        'pasang_gambar',
                        'tanda_daftar_nama',
                        'pertimbangkan_obat',
                        'alat_bantu_jalan',
                        'pintu_terbuka',
                        'jangan_tinggalkan',
                        'dekat_nurse_station',
                        'bed_posisi_rendah',
                        'edukasi_keluarga'
                    ];

                    foreach ($highRiskFields as $field) {
                        $data[$field] = $request->has($field) ? 1 : 0;
                    }
                }
            }

            // Simpan data
            RmeSkalaHumptyDumpty::create($data);

            DB::commit();

            return redirect()->route('rawat-inap.resiko-jatuh.humpty-dumpty.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Skala Humpty Dumpty berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Ambil data Humpty Dumpty berdasarkan ID
        $dataHumptyDumpty = RmeSkalaHumptyDumpty::where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        if (!$dataHumptyDumpty) {
            abort(404, 'Data Humpty Dumpty tidak ditemukan');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-humpty-dumpty.edit', compact(
            'dataMedis',
            'dataHumptyDumpty'
        ));
    }

    public function update(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Validasi input
        $request->validate([
            'tanggal_implementasi' => 'required|date',
            'jam_implementasi' => 'required',
            'shift' => 'required|in:PG,SI,ML'
        ]);

        DB::beginTransaction();

        try {
            // Debug: Log semua input request untuk update
            Log::info('Humpty Dumpty Update Request Data:', [
                'id' => $id,
                'use_existing_assessment' => $request->use_existing_assessment,
                'total_skor' => $request->total_skor,
                'kategori_risiko' => $request->kategori_risiko,
                'existing_total_skor' => $request->existing_total_skor,
                'existing_kategori_risiko' => $request->existing_kategori_risiko,
            ]);

            // Ambil data yang akan diupdate
            $dataHumptyDumpty = RmeSkalaHumptyDumpty::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataHumptyDumpty) {
                abort(404, 'Data Humpty Dumpty tidak ditemukan');
            }

            // Validasi duplikasi tanggal dan shift (kecuali data yang sedang diedit)
            $existingData = RmeSkalaHumptyDumpty::where('kd_pasien', $kd_pasien)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->where('tanggal_implementasi', $request->tanggal_implementasi)
                ->where('shift', $request->shift)
                ->where('id', '!=', $id)
                ->first();

            if ($existingData) {
                return back()->with('error', 'Data dengan tanggal ' . date('d/m/Y', strtotime($request->tanggal_implementasi)) . ' dan shift ' . ucfirst($request->shift) . ' sudah ada!')
                    ->withInput();
            }

            // Update data dasar
            $dataHumptyDumpty->tanggal_implementasi = $request->tanggal_implementasi;
            $dataHumptyDumpty->jam_implementasi = $request->jam_implementasi;
            $dataHumptyDumpty->shift = $request->shift;

            // Logika penilaian yang sama seperti store
            if ($request->use_existing_assessment == '0') {
                // Menggunakan penilaian baru (untuk konsistensi, meskipun di edit biasanya selalu update)
                $totalSkor = (int)$request->usia +
                    (int)$request->jenis_kelamin +
                    (int)$request->diagnosis +
                    (int)$request->gangguan_kognitif +
                    (int)$request->faktor_lingkungan +
                    (int)$request->pembedahan_sedasi +
                    (int)$request->penggunaan_medikamentosa;

                // Tentukan kategori risiko
                if ($totalSkor >= 6 && $totalSkor <= 11) {
                    $kategoriRisiko = 'Risiko Rendah';
                } elseif ($totalSkor >= 12) {
                    $kategoriRisiko = 'Risiko Tinggi';
                } else {
                    $kategoriRisiko = 'Skor Tidak Valid';
                }

                // Update data assessment
                $dataHumptyDumpty->usia = (int)$request->usia;
                $dataHumptyDumpty->jenis_kelamin = (int)$request->jenis_kelamin;
                $dataHumptyDumpty->diagnosis = (int)$request->diagnosis;
                $dataHumptyDumpty->gangguan_kognitif = (int)$request->gangguan_kognitif;
                $dataHumptyDumpty->faktor_lingkungan = (int)$request->faktor_lingkungan;
                $dataHumptyDumpty->pembedahan_sedasi = (int)$request->pembedahan_sedasi;
                $dataHumptyDumpty->penggunaan_medikamentosa = (int)$request->penggunaan_medikamentosa;
                $dataHumptyDumpty->total_skor = $totalSkor;
                $dataHumptyDumpty->kategori_risiko = $kategoriRisiko;
            } else {
                // Gunakan data existing atau data terakhir yang valid (sama seperti store)
                if ($request->has('existing_usia')) {
                    // Gunakan data dari hidden input (existing)
                    $dataHumptyDumpty->usia = $request->existing_usia;
                    $dataHumptyDumpty->jenis_kelamin = $request->existing_jenis_kelamin;
                    $dataHumptyDumpty->diagnosis = $request->existing_diagnosis;
                    $dataHumptyDumpty->gangguan_kognitif = $request->existing_gangguan_kognitif;
                    $dataHumptyDumpty->faktor_lingkungan = $request->existing_faktor_lingkungan;
                    $dataHumptyDumpty->pembedahan_sedasi = $request->existing_pembedahan_sedasi;
                    $dataHumptyDumpty->penggunaan_medikamentosa = $request->existing_penggunaan_medikamentosa;
                    $dataHumptyDumpty->total_skor = $request->existing_total_skor;
                    $dataHumptyDumpty->kategori_risiko = $request->existing_kategori_risiko;
                } else {
                    // Fallback: Gunakan data terakhir yang valid
                    $lastAssessment = RmeSkalaHumptyDumpty::where('kd_pasien', $kd_pasien)
                        ->where('kd_unit', $kd_unit)
                        ->whereDate('tgl_masuk', $tgl_masuk)
                        ->where('urut_masuk', $urut_masuk)
                        ->where('id', '!=', $id) // Exclude current record
                        ->whereNotNull('usia')
                        ->whereNotNull('jenis_kelamin')
                        ->whereNotNull('diagnosis')
                        ->whereNotNull('gangguan_kognitif')
                        ->whereNotNull('faktor_lingkungan')
                        ->whereNotNull('pembedahan_sedasi')
                        ->whereNotNull('penggunaan_medikamentosa')
                        ->where('total_skor', '>', 0)
                        ->orderBy('tanggal_implementasi', 'desc')
                        ->orderBy('jam_implementasi', 'desc')
                        ->first();

                    if ($lastAssessment) {
                        $dataHumptyDumpty->usia = $lastAssessment->usia;
                        $dataHumptyDumpty->jenis_kelamin = $lastAssessment->jenis_kelamin;
                        $dataHumptyDumpty->diagnosis = $lastAssessment->diagnosis;
                        $dataHumptyDumpty->gangguan_kognitif = $lastAssessment->gangguan_kognitif;
                        $dataHumptyDumpty->faktor_lingkungan = $lastAssessment->faktor_lingkungan;
                        $dataHumptyDumpty->pembedahan_sedasi = $lastAssessment->pembedahan_sedasi;
                        $dataHumptyDumpty->penggunaan_medikamentosa = $lastAssessment->penggunaan_medikamentosa;
                        $dataHumptyDumpty->total_skor = $lastAssessment->total_skor;
                        $dataHumptyDumpty->kategori_risiko = $lastAssessment->kategori_risiko;
                    }
                    // Jika tidak ada fallback, tetap gunakan data yang sudah ada di record ini
                }
            }

            // Reset semua intervensi terlebih dahulu
            $interventionFields = [
                'observasi_ambulasi',
                'orientasi_kamar_mandi',
                'orientasi_bertahap',
                'tempatkan_bel',
                'instruksi_bantuan',
                'pagar_pengaman',
                'tempat_tidur_rendah',
                'edukasi_perilaku',
                'monitor_berkala',
                'anjuran_kaus_kaki',
                'lantai_antislip',
                'semua_intervensi_rendah',
                'gelang_kuning',
                'pasang_gambar',
                'tanda_daftar_nama',
                'pertimbangkan_obat',
                'alat_bantu_jalan',
                'pintu_terbuka',
                'jangan_tinggalkan',
                'dekat_nurse_station',
                'bed_posisi_rendah',
                'edukasi_keluarga'
            ];

            foreach ($interventionFields as $field) {
                $dataHumptyDumpty->$field = 0;
            }

            // Set intervensi berdasarkan kategori dan input
            if ($dataHumptyDumpty->kategori_risiko == 'Risiko Rendah') {
                $lowRiskFields = [
                    'observasi_ambulasi',
                    'orientasi_kamar_mandi',
                    'orientasi_bertahap',
                    'tempatkan_bel',
                    'instruksi_bantuan',
                    'pagar_pengaman',
                    'tempat_tidur_rendah',
                    'edukasi_perilaku',
                    'monitor_berkala',
                    'anjuran_kaus_kaki',
                    'lantai_antislip'
                ];

                foreach ($lowRiskFields as $field) {
                    $dataHumptyDumpty->$field = $request->has($field) ? 1 : 0;
                }
            }

            if ($dataHumptyDumpty->kategori_risiko == 'Risiko Tinggi') {
                $highRiskFields = [
                    'semua_intervensi_rendah',
                    'gelang_kuning',
                    'pasang_gambar',
                    'tanda_daftar_nama',
                    'pertimbangkan_obat',
                    'alat_bantu_jalan',
                    'pintu_terbuka',
                    'jangan_tinggalkan',
                    'dekat_nurse_station',
                    'bed_posisi_rendah',
                    'edukasi_keluarga'
                ];

                foreach ($highRiskFields as $field) {
                    $dataHumptyDumpty->$field = $request->has($field) ? 1 : 0;
                }
            }

            $dataHumptyDumpty->user_updated = auth()->user()->id;
            $dataHumptyDumpty->save();

            DB::commit();

            return redirect()->route('rawat-inap.resiko-jatuh.humpty-dumpty.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Skala Humpty Dumpty berhasil diupdate!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage())->withInput();
        }
    }

    public function show($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->where('kunjungan.kd_unit', $kd_unit)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Hitung umur pasien
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Ambil data Humpty Dumpty berdasarkan ID
        $dataHumptyDumpty = RmeSkalaHumptyDumpty::with('userCreated')
            ->where('id', $id)
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        if (!$dataHumptyDumpty) {
            abort(404, 'Data Humpty Dumpty tidak ditemukan');
        }

        return view('unit-pelayanan.rawat-inap.pelayanan.resiko-jatuh.skala-humpty-dumpty.show', compact(
            'dataMedis',
            'dataHumptyDumpty'
        ));
    }

    public function destroy($kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            // Ambil data yang akan dihapus
            $dataHumptyDumpty = RmeSkalaHumptyDumpty::where('id', $id)
                ->where('kd_pasien', $kd_pasien)
                ->where('kd_unit', $kd_unit)
                ->where('tgl_masuk', $tgl_masuk)
                ->where('urut_masuk', $urut_masuk)
                ->first();

            if (!$dataHumptyDumpty) {
                return back()->with('error', 'Data Humpty Dumpty tidak ditemukan!');
            }

            $dataHumptyDumpty->delete();

            return redirect()->route('rawat-inap.resiko-jatuh.humpty-dumpty.index', [$kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Data Skala Humpty Dumpty berhasil dihapus!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
