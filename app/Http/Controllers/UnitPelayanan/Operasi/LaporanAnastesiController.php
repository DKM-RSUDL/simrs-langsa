<?php

namespace App\Http\Controllers\UnitPelayanan\Operasi;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\DokterAnastesi;
use App\Models\Kunjungan;
use App\Models\OkJenisAnastesi;
use App\Models\OkLaporanAnastesi;
use App\Models\OkLaporanAnastesiDtl;
use App\Models\OkLaporanAnastesiDtl2;
use App\Models\Perawat;
use App\Models\RmeCeklistKesiapanAnesthesi;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanAnastesiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/operasi');
    }

    public function index($kd_pasien, $tgl_masuk, $urut_masuk)
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

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // Fetch Laporan Anastesi records for this patient and visit
        $laporanAnastesi = OkLaporanAnastesi::with('userCreate') // Assuming user_created relation exists
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('id', 'desc')
            ->get();

        $ceklistKesiapanAnesthesi = RmeCeklistKesiapanAnesthesi::with('userCreate')
            ->where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('unit-pelayanan.operasi.pelayanan.laporan-anastesi.index', compact(
            'dataMedis',
            'laporanAnastesi',
            'ceklistKesiapanAnesthesi',
        ));
    }

    public function create($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Logika yang sama jika diperlukan
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

        $jenisAnastesi = OkJenisAnastesi::all();
        $dokterAnastesi = DokterAnastesi::all();
        $dokter = Dokter::where('status', 1)->get();
        $perawat = Perawat::where('aktif', 1)->get();


        return view('unit-pelayanan.operasi.pelayanan.laporan-anastesi.create', compact('dataMedis', 'jenisAnastesi', 'dokterAnastesi', 'dokter', 'perawat'));
    }


    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {

            // Combine date and time for waktu_mulai_operasi
            $tanggal_mulai = $request->waktu_mulai_operasi;
            $jam_mulai = $request->jam_mulai_operasi;
            $waktu_mulai_operasi = $tanggal_mulai . ' ' . $jam_mulai;

            // Combine date and time for waktu_selesai_operasi
            $tanggal_selesai = $request->waktu_selesai_operasi;
            $jam_selesai = $request->jam_selesai_operasi;
            $waktu_selesai_operasi = $tanggal_selesai . ' ' . $jam_selesai;

            // Existing code for waktu_anastesi
            $tanggal = $request->tgl_data_masuk;
            $jam = $request->jam_masuk;
            $waktu_anastesi = $tanggal . ' ' . $jam;

            //combine pencatatan
            $tanggal_pencatatan = $request->tanggal_pencatatan;
            $jam_pencatatan = $request->jam_pencatatan;
            $waktu_pencatatan = $tanggal_pencatatan . ' ' . $jam_pencatatan;

            $laporanAnastesi = new OkLaporanAnastesi();
            $laporanAnastesi->kd_pasien = $kd_pasien;
            $laporanAnastesi->tgl_masuk = $tgl_masuk;
            $laporanAnastesi->urut_masuk = $urut_masuk;
            $laporanAnastesi->user_created = auth()->user()->id;
            $laporanAnastesi->waktu_laporan = $waktu_anastesi ?? '';
            $laporanAnastesi->jenis_operasi = $request->jenis_operasi;
            $laporanAnastesi->tipe_operasi = $request->tipe_operasi;
            $laporanAnastesi->time_out = $request->time_out;
            $laporanAnastesi->jam_time_out = $request->jam_time_out;
            $laporanAnastesi->tingkat_kesadaran = $request->tingkat_kesadaran;
            $laporanAnastesi->posisi_pasien = $request->posisi_pasien;
            $laporanAnastesi->posisi_lengan = $request->posisi_lengan;
            $laporanAnastesi->posisi_kanula = $request->posisi_kanula;
            $laporanAnastesi->pemasangan_kater_urin = $request->pemasangan_kater_urin;
            $laporanAnastesi->dilakukan_kater = $request->bila_kater_urin;
            $laporanAnastesi->persiapan_kulit = $request->persiapan_kulit;
            $laporanAnastesi->waktu_mulai_operasi = $waktu_mulai_operasi ?? '';
            $laporanAnastesi->waktu_selesai_operasi = $waktu_selesai_operasi ?? '';
            $laporanAnastesi->dokter_bedah = $request->dokter_bedah;
            $laporanAnastesi->dokter_anastesi = $request->dokter_anastesi;
            $laporanAnastesi->penatara_anastesi = $request->penatara_anastesi;
            $laporanAnastesi->perawat_instrumen = $request->perawat_instrumen;
            $laporanAnastesi->perawat_sirkuler = $request->perawat_sirkuler;
            $laporanAnastesi->tanggal_jam_pencatatan = $waktu_pencatatan ?? '';
            $laporanAnastesi->save();


            $lapAnastesiDtl = new OkLaporanAnastesiDtl();
            $lapAnastesiDtl->id_laporan_anastesi = $laporanAnastesi->id;
            $lapAnastesiDtl->instrument = $request->instrumen;
            $lapAnastesiDtl->instrument_time = $request->jam_instrumen;
            $lapAnastesiDtl->prothese = $request->prothese;
            $lapAnastesiDtl->prothese_time = $request->jam_prothese;
            $lapAnastesiDtl->pemakaian_diathermy = $request->diathermy;
            $lapAnastesiDtl->lokasi_diathermy = $request->lokasi_diathermy;
            $lapAnastesiDtl->kode_elektrosurgical = $request->kode_unit_elektrosurgical;
            $lapAnastesiDtl->unit_pemasangan = $request->unit_pemasangan;
            $lapAnastesiDtl->temperatur_mulai = $request->pengaturan_temperatur_mulai;
            $lapAnastesiDtl->temperatur_selesai = $request->pengaturan_temperatur_selesai;
            $lapAnastesiDtl->jam_temperatur_mulai = $request->jam_temperatur_mulai;
            $lapAnastesiDtl->jam_temperatur_selesai = $request->jam_temperatur_selesai;
            $lapAnastesiDtl->kode_unit = $request->kode_unit;
            $lapAnastesiDtl->pemakaian_tomiquet = $request->pemakaian_tomiquet;
            $lapAnastesiDtl->pengawas_tomiquet = $request->pengawas_tomiquet;
            $lapAnastesiDtl->lengan_kanan_mulai = $request->jam_lengan_kanan_mulai;
            $lapAnastesiDtl->lengan_kanan_selesai = $request->jam_lengan_kanan_selesai;
            $lapAnastesiDtl->lengan_kanan_tekanan = $request->tekanan_lengan_kanan;
            $lapAnastesiDtl->kaki_kanan_mulai = $request->jam_kaki_kanan_mulai;
            $lapAnastesiDtl->kaki_kanan_selesai = $request->jam_kaki_kanan_selesai;
            $lapAnastesiDtl->kaki_kanan_tekanan = $request->tekanan_kaki_kanan;
            $lapAnastesiDtl->lengan_kiri_mulai = $request->jam_lengan_kiri_mulai;
            $lapAnastesiDtl->lengan_kiri_selesai = $request->jam_lengan_kiri_selesai;
            $lapAnastesiDtl->lengan_kiri_tekanan = $request->tekanan_lengan_kiri;
            $lapAnastesiDtl->kaki_kiri_mulai = $request->jam_kaki_kiri_mulai;
            $lapAnastesiDtl->kaki_kiri_selesai = $request->jam_kaki_kiri_selesai;
            $lapAnastesiDtl->kaki_kiri_tekanan = $request->tekanan_kaki_kiri;
            $lapAnastesiDtl->pemakaian_laser = $request->pemakaian_laser;
            $lapAnastesiDtl->kode_model = $request->kode_model;
            $lapAnastesiDtl->pengawas_laser = $request->pengawas_laser;
            $lapAnastesiDtl->pemakaian_implant = $request->pemakaian_implant;
            $lapAnastesiDtl->pabrik = $request->pabrik;
            $lapAnastesiDtl->size = $request->size;
            $lapAnastesiDtl->type = $request->tipe;
            $lapAnastesiDtl->no_seri = $request->no_seri;
            $lapAnastesiDtl->save();

            $lapAnastesiDtlDua = new OkLaporanAnastesiDtl2();
            $lapAnastesiDtlDua->id_laporan_anastesi = $laporanAnastesi->id;
            $lapAnastesiDtlDua->kassa_satu = $request->kassa1;
            $lapAnastesiDtlDua->jarum_satu = $request->jarum1;
            $lapAnastesiDtlDua->instrumen_satu = $request->instrumen1;
            $lapAnastesiDtlDua->kassa_dua = $request->kassa2;
            $lapAnastesiDtlDua->jarum_dua = $request->jarum2;
            $lapAnastesiDtlDua->instrumen_dua = $request->instrumen2;
            $lapAnastesiDtlDua->kassa_tiga = $request->kassa3;
            $lapAnastesiDtlDua->jarum_tiga = $request->jarum3;
            $lapAnastesiDtlDua->instrumen_tiga = $request->instrumen3;
            // $lapAnastesiDtlDua->kassa_tidak_lengkap = $request->kassa4 ?? '0';
            // $lapAnastesiDtlDua->jarum_tidak_lengkap = $request->jarum4 ?? '0';
            // $lapAnastesiDtlDua->instrumen_tidak_lengkap = $request->instrumen4 ?? '0';
            // $lapAnastesiDtlDua->kassa_tidak_perlu = $request->kassa5 ?? '0';
            // $lapAnastesiDtlDua->jarum_tidak_perlu = $request->jarum5 ?? '0';
            // $lapAnastesiDtlDua->instrumen_tidak_perlu = $request->instrumen5 ?? '0';
            $lapAnastesiDtlDua->dilakukan_xray = $request->dilakukan_xray;
            $lapAnastesiDtlDua->penggunaan_tampon = $request->penggunaan_tampon;
            $lapAnastesiDtlDua->jenis_tampon = $request->jenis_tampon;

            // Collect drain data and convert to JSON
            $drainData = [
                [
                    'tipe_drain' => $request->tipe_drain,
                    'jenis_drain' => $request->jenis_drain,
                    'ukuran' => $request->ukuran_drain,
                    'keterangan' => $request->keterangan_drain
                ],
                [
                    'tipe_drain' => $request->tipe_drain2,
                    'jenis_drain' => $request->jenis_drain2,
                    'ukuran' => $request->ukuran_drain2,
                    'keterangan' => $request->keterangan_drain2
                ],
                [
                    'tipe_drain' => $request->tipe_drain3,
                    'jenis_drain' => $request->jenis_drain3,
                    'ukuran' => $request->ukuran_drain3,
                    'keterangan' => $request->keterangan_drain3
                ]
            ];
            // Filter out empty entries and encode to JSON
            $filteredDrainData = array_filter($drainData, function ($item) {
                return !empty($item['tipe_drain']) || !empty($item['jenis_drain']) ||
                    !empty($item['ukuran']) || !empty($item['keterangan']);
            });
            $lapAnastesiDtlDua->penggunaan_cairan_drain = json_encode($filteredDrainData);

            $lapAnastesiDtlDua->irigasi_luka = $request->irigasi_luka;

            // Pemakaian Cairan
            $pemakaianCairan = json_decode($request->pemakaian_cairan, true) ?: [];
            $lapAnastesiDtlDua->pemakaian_cairan = json_encode($pemakaianCairan);

            $lapAnastesiDtlDua->pemeriksaan_kondisi_kulit_pra_operasi = $request->pemeriksaan_kondisi_kulit_pra_operasi;
            $lapAnastesiDtlDua->pemeriksaan_kondisi_kulit_pasca_operasi = $request->pemeriksaan_kondisi_kulit_pasca_operasi;
            $lapAnastesiDtlDua->balutan_luka = $request->balutan_luka;
            $lapAnastesiDtlDua->spesimen = $request->spesimen;
            $lapAnastesiDtlDua->jenis_spesimen = $request->jenis_spesimen;
            $lapAnastesiDtlDua->total_jaringan_cairan_pemeriksaan = $request->total_jaringan_cairan_pemeriksaan;
            $lapAnastesiDtlDua->jenis_jaringan = $request->jenis_jaringan;
            $lapAnastesiDtlDua->jumlah_jaringan = $request->jumlah_jaringan;
            $lapAnastesiDtlDua->keterangan = $request->keterangan;
            $lapAnastesiDtlDua->save();

            DB::commit();
            return to_route('operasi.pelayanan.laporan-anastesi.index', [$kd_pasien, $tgl_masuk, $urut_masuk])->with('success', 'Laporan Anestesi berhasil di tambah !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Get patient data similar to create method
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

        // Calculate age based on birth date if available
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Retrieve the specific anesthesia report with its relationships
        $laporanAnastesi = OkLaporanAnastesi::with('userCreate')
            ->where('id', $id)
            ->firstOrFail();

        // Get the detail records related to this report
        $laporanAnastesiDtl = OkLaporanAnastesiDtl::where('id_laporan_anastesi', $id)->first();
        $laporanAnastesiDtl2 = OkLaporanAnastesiDtl2::where('id_laporan_anastesi', $id)->first();

        // Get reference data for display purposes
        $jenisAnastesi = OkJenisAnastesi::all();
        $dokterAnastesi = DokterAnastesi::all();
        $dokter = Dokter::where('status', 1)->get();
        $perawat = Perawat::where('aktif', 1)->get();

        // Decode drain data from JSON if it exists
        $drainData = null;
        if ($laporanAnastesiDtl2 && $laporanAnastesiDtl2->penggunaan_cairan_drain) {
            $drainData = json_decode($laporanAnastesiDtl2->penggunaan_cairan_drain, true);
        }

        return view('unit-pelayanan.operasi.pelayanan.laporan-anastesi.show', compact(
            'dataMedis',
            'laporanAnastesi',
            'laporanAnastesiDtl',
            'laporanAnastesiDtl2',
            'jenisAnastesi',
            'dokterAnastesi',
            'dokter',
            'perawat',
            'drainData'
        ));
    }


    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Get patient data similar to create method
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

        // Calculate age based on birth date if available
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Retrieve the specific anesthesia report with its relationships
        $laporanAnastesi = OkLaporanAnastesi::where('id', $id)->firstOrFail();

        // Get the detail records related to this report
        $laporanAnastesiDtl = OkLaporanAnastesiDtl::where('id_laporan_anastesi', $id)->first();
        $laporanAnastesiDtl2 = OkLaporanAnastesiDtl2::where('id_laporan_anastesi', $id)->first();

        // Get reference data for display purposes
        $jenisAnastesi = OkJenisAnastesi::all();
        $dokterAnastesi = DokterAnastesi::all();
        $dokter = Dokter::where('status', 1)->get();
        $perawat = Perawat::where('aktif', 1)->get();

        // Parse dates and times for form fields
        $waktuLaporan = null;
        $jamLaporan = null;
        if ($laporanAnastesi->waktu_laporan) {
            $waktuLaporanObj = Carbon::parse($laporanAnastesi->waktu_laporan);
            $waktuLaporan = $waktuLaporanObj->format('Y-m-d');
            $jamLaporan = $waktuLaporanObj->format('H:i');
        }

        $waktuMulaiOperasi = null;
        $jamMulaiOperasi = null;
        if ($laporanAnastesi->waktu_mulai_operasi) {
            $waktuMulaiOperasiObj = Carbon::parse($laporanAnastesi->waktu_mulai_operasi);
            $waktuMulaiOperasi = $waktuMulaiOperasiObj->format('Y-m-d');
            $jamMulaiOperasi = $waktuMulaiOperasiObj->format('H:i');
        }

        $waktuSelesaiOperasi = null;
        $jamSelesaiOperasi = null;
        if ($laporanAnastesi->waktu_selesai_operasi) {
            $waktuSelesaiOperasiObj = Carbon::parse($laporanAnastesi->waktu_selesai_operasi);
            $waktuSelesaiOperasi = $waktuSelesaiOperasiObj->format('Y-m-d');
            $jamSelesaiOperasi = $waktuSelesaiOperasiObj->format('H:i');
        }

        $tanggalPencatatan = null;
        $jamPencatatan = null;
        if ($laporanAnastesi->tanggal_jam_pencatatan) {
            $tanggalJamPencatatanObj = Carbon::parse($laporanAnastesi->tanggal_jam_pencatatan);
            $tanggalPencatatan = $tanggalJamPencatatanObj->format('Y-m-d');
            $jamPencatatan = $tanggalJamPencatatanObj->format('H:i');
        }

        // Decode drain data from JSON if it exists
        $drainData = [];
        if ($laporanAnastesiDtl2 && $laporanAnastesiDtl2->penggunaan_cairan_drain) {
            $drainData = json_decode($laporanAnastesiDtl2->penggunaan_cairan_drain, true);
        }

        // Ensure we have 3 drain entries for the form (filled or empty)
        while (count($drainData) < 3) {
            $drainData[] = [
                'tipe_drain' => '',
                'jenis_drain' => '',
                'ukuran' => '',
                'keterangan' => ''
            ];
        }

        return view('unit-pelayanan.operasi.pelayanan.laporan-anastesi.edit', compact(
            'dataMedis',
            'laporanAnastesi',
            'laporanAnastesiDtl',
            'laporanAnastesiDtl2',
            'jenisAnastesi',
            'dokterAnastesi',
            'dokter',
            'perawat',
            'drainData',
            'waktuLaporan',
            'jamLaporan',
            'waktuMulaiOperasi',
            'jamMulaiOperasi',
            'waktuSelesaiOperasi',
            'jamSelesaiOperasi',
            'tanggalPencatatan',
            'jamPencatatan'
        ));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {
            // Find the existing records
            $laporanAnastesi = OkLaporanAnastesi::findOrFail($id);
            $laporanAnastesiDtl = OkLaporanAnastesiDtl::where('id_laporan_anastesi', $id)->first();
            $laporanAnastesiDtl2 = OkLaporanAnastesiDtl2::where('id_laporan_anastesi', $id)->first();

            if (!$laporanAnastesiDtl || !$laporanAnastesiDtl2) {
                throw new Exception('Detail data not found');
            }

            // Combine date and time for waktu_mulai_operasi
            $tanggal_mulai = $request->waktu_mulai_operasi;
            $jam_mulai = $request->jam_mulai_operasi;
            $waktu_mulai_operasi = $tanggal_mulai . ' ' . $jam_mulai;

            // Combine date and time for waktu_selesai_operasi
            $tanggal_selesai = $request->waktu_selesai_operasi;
            $jam_selesai = $request->jam_selesai_operasi;
            $waktu_selesai_operasi = $tanggal_selesai . ' ' . $jam_selesai;

            // Existing code for waktu_anastesi
            $tanggal = $request->tgl_data_masuk;
            $jam = $request->jam_masuk;
            $waktu_anastesi = $tanggal . ' ' . $jam;

            //combine pencatatan
            $tanggal_pencatatan = $request->tanggal_pencatatan;
            $jam_pencatatan = $request->jam_pencatatan;
            $waktu_pencatatan = $tanggal_pencatatan . ' ' . $jam_pencatatan;

            // Update main record
            $laporanAnastesi->user_created = auth()->user()->id;
            $laporanAnastesi->waktu_laporan = $waktu_anastesi ?? '';
            $laporanAnastesi->jenis_operasi = $request->jenis_operasi;
            $laporanAnastesi->tipe_operasi = $request->tipe_operasi;
            $laporanAnastesi->time_out = $request->time_out;
            $laporanAnastesi->jam_time_out = $request->jam_time_out;
            $laporanAnastesi->tingkat_kesadaran = $request->tingkat_kesadaran;
            $laporanAnastesi->posisi_pasien = $request->posisi_pasien;
            $laporanAnastesi->posisi_lengan = $request->posisi_lengan;
            $laporanAnastesi->posisi_kanula = $request->posisi_kanula;
            $laporanAnastesi->pemasangan_kater_urin = $request->pemasangan_kater_urin;
            $laporanAnastesi->dilakukan_kater = $request->bila_kater_urin;
            $laporanAnastesi->persiapan_kulit = $request->persiapan_kulit;
            $laporanAnastesi->waktu_mulai_operasi = $waktu_mulai_operasi ?? '';
            $laporanAnastesi->waktu_selesai_operasi = $waktu_selesai_operasi ?? '';
            $laporanAnastesi->dokter_bedah = $request->dokter_bedah;
            $laporanAnastesi->dokter_anastesi = $request->dokter_anastesi;
            $laporanAnastesi->penatara_anastesi = $request->penatara_anastesi;
            $laporanAnastesi->perawat_instrumen = $request->perawat_instrumen;
            $laporanAnastesi->perawat_sirkuler = $request->perawat_sirkuler;
            $laporanAnastesi->tanggal_jam_pencatatan = $waktu_pencatatan ?? '';
            $laporanAnastesi->save();

            // Update detail record
            $laporanAnastesiDtl->instrument = $request->instrumen;
            $laporanAnastesiDtl->instrument_time = $request->jam_instrumen;
            $laporanAnastesiDtl->prothese = $request->prothese;
            $laporanAnastesiDtl->prothese_time = $request->jam_prothese;
            $laporanAnastesiDtl->pemakaian_diathermy = $request->diathermy;
            $laporanAnastesiDtl->lokasi_diathermy = $request->lokasi_diathermy;
            $laporanAnastesiDtl->kode_elektrosurgical = $request->kode_unit_elektrosurgical;
            $laporanAnastesiDtl->unit_pemasangan = $request->unit_pemasangan;
            $laporanAnastesiDtl->temperatur_mulai = $request->pengaturan_temperatur_mulai;
            $laporanAnastesiDtl->temperatur_selesai = $request->pengaturan_temperatur_selesai;
            $laporanAnastesiDtl->jam_temperatur_mulai = $request->jam_temperatur_mulai;
            $laporanAnastesiDtl->jam_temperatur_selesai = $request->jam_temperatur_selesai;
            $laporanAnastesiDtl->kode_unit = $request->kode_unit;
            $laporanAnastesiDtl->pemakaian_tomiquet = $request->pemakaian_tomiquet;
            $laporanAnastesiDtl->pengawas_tomiquet = $request->pengawas_tomiquet;
            $laporanAnastesiDtl->lengan_kanan_mulai = $request->jam_lengan_kanan_mulai;
            $laporanAnastesiDtl->lengan_kanan_selesai = $request->jam_lengan_kanan_selesai;
            $laporanAnastesiDtl->lengan_kanan_tekanan = $request->tekanan_lengan_kanan;
            $laporanAnastesiDtl->kaki_kanan_mulai = $request->jam_kaki_kanan_mulai;
            $laporanAnastesiDtl->kaki_kanan_selesai = $request->jam_kaki_kanan_selesai;
            $laporanAnastesiDtl->kaki_kanan_tekanan = $request->tekanan_kaki_kanan;
            $laporanAnastesiDtl->lengan_kiri_mulai = $request->jam_lengan_kiri_mulai;
            $laporanAnastesiDtl->lengan_kiri_selesai = $request->jam_lengan_kiri_selesai;
            $laporanAnastesiDtl->lengan_kiri_tekanan = $request->tekanan_lengan_kiri;
            $laporanAnastesiDtl->kaki_kiri_mulai = $request->jam_kaki_kiri_mulai;
            $laporanAnastesiDtl->kaki_kiri_selesai = $request->jam_kaki_kiri_selesai;
            $laporanAnastesiDtl->kaki_kiri_tekanan = $request->tekanan_kaki_kiri;
            $laporanAnastesiDtl->pemakaian_laser = $request->pemakaian_laser;
            $laporanAnastesiDtl->kode_model = $request->kode_model;
            $laporanAnastesiDtl->pengawas_laser = $request->pengawas_laser;
            $laporanAnastesiDtl->pemakaian_implant = $request->pemakaian_implant;
            $laporanAnastesiDtl->pabrik = $request->pabrik;
            $laporanAnastesiDtl->size = $request->size;
            $laporanAnastesiDtl->type = $request->tipe;
            $laporanAnastesiDtl->no_seri = $request->no_seri;
            $laporanAnastesiDtl->save();

            // Update detail2 record
            $laporanAnastesiDtl2->kassa_satu = $request->kassa1;
            $laporanAnastesiDtl2->jarum_satu = $request->jarum1;
            $laporanAnastesiDtl2->instrumen_satu = $request->instrumen1;
            $laporanAnastesiDtl2->kassa_dua = $request->kassa2;
            $laporanAnastesiDtl2->jarum_dua = $request->jarum2;
            $laporanAnastesiDtl2->instrumen_dua = $request->instrumen2;
            $laporanAnastesiDtl2->kassa_tiga = $request->kassa3;
            $laporanAnastesiDtl2->jarum_tiga = $request->jarum3;
            $laporanAnastesiDtl2->instrumen_tiga = $request->instrumen3;
            $laporanAnastesiDtl2->dilakukan_xray = $request->dilakukan_xray;
            $laporanAnastesiDtl2->penggunaan_tampon = $request->penggunaan_tampon;
            $laporanAnastesiDtl2->jenis_tampon = $request->jenis_tampon;

            // Collect drain data and convert to JSON
            $drainData = [
                [
                    'tipe_drain' => $request->tipe_drain,
                    'jenis_drain' => $request->jenis_drain,
                    'ukuran' => $request->ukuran_drain,
                    'keterangan' => $request->keterangan_drain
                ],
                [
                    'tipe_drain' => $request->tipe_drain2,
                    'jenis_drain' => $request->jenis_drain2,
                    'ukuran' => $request->ukuran_drain2,
                    'keterangan' => $request->keterangan_drain2
                ],
                [
                    'tipe_drain' => $request->tipe_drain3,
                    'jenis_drain' => $request->jenis_drain3,
                    'ukuran' => $request->ukuran_drain3,
                    'keterangan' => $request->keterangan_drain3
                ]
            ];

            // Filter out empty entries and encode to JSON
            $filteredDrainData = array_filter($drainData, function ($item) {
                return !empty($item['tipe_drain']) || !empty($item['jenis_drain']) ||
                    !empty($item['ukuran']) || !empty($item['keterangan']);
            });
            $laporanAnastesiDtl2->penggunaan_cairan_drain = json_encode($filteredDrainData);

            $laporanAnastesiDtl2->irigasi_luka = $request->irigasi_luka;

            // Pemakaian Cairan
            $pemakaianCairan = json_decode($request->pemakaian_cairan, true) ?: [];
            $laporanAnastesiDtl2->pemakaian_cairan = json_encode($pemakaianCairan);
            $laporanAnastesiDtl2->pemeriksaan_kondisi_kulit_pra_operasi = $request->pemeriksaan_kondisi_kulit_pra_operasi;
            $laporanAnastesiDtl2->pemeriksaan_kondisi_kulit_pasca_operasi = $request->pemeriksaan_kondisi_kulit_pasca_operasi;
            $laporanAnastesiDtl2->balutan_luka = $request->balutan_luka;
            $laporanAnastesiDtl2->spesimen = $request->spesimen;
            $laporanAnastesiDtl2->jenis_spesimen = $request->jenis_spesimen;
            $laporanAnastesiDtl2->total_jaringan_cairan_pemeriksaan = $request->total_jaringan_cairan_pemeriksaan;
            $laporanAnastesiDtl2->jenis_jaringan = $request->jenis_jaringan;
            $laporanAnastesiDtl2->jumlah_jaringan = $request->jumlah_jaringan;
            $laporanAnastesiDtl2->keterangan = $request->keterangan;
            $laporanAnastesiDtl2->save();

            DB::commit();
            return to_route('operasi.pelayanan.laporan-anastesi.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('success', 'Laporan Anestesi berhasil diperbarui!');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
