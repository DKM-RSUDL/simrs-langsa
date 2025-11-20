<?php

namespace App\Http\Controllers\UnitPelayanan\Operasi;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\HrdKaryawan;
use App\Models\OrderOK;
use App\Models\PasienInap;
use App\Models\RmeAlergiPasien;
use App\Models\RmeCatatanPemberianObat;
use App\Models\RmeSerahTerima;
use App\Models\RmeTransferPasienAntarRuang;
use App\Models\Unit;
use App\Services\BaseService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransferPasienController extends Controller
{
    private $baseService;
    private $kdUnit;

    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/rawat-inap');
        $this->baseService = new BaseService();
        $this->kdUnit = 71;
    }

    public function index(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // get order OK
        $order = OrderOK::where('kd_kasir_ok', $dataMedis->kd_kasir)
            ->where('no_transaksi_ok', $dataMedis->no_transaksi)
            ->first();

        if (empty($order)) return back()->with('error', 'Pasien belum memiliki order atau tidak melalui RME saat order !');

        $dataMedisAsal = $this->baseService->getDataMedisbyTransaksi($order->kd_kasir, $order->no_transaksi);

        if (empty($dataMedisAsal)) {
            abort(404, 'Data medis asal not found');
        }

        // Query untuk data transfer pasien antar ruang
        $kdUnit = $this->kdUnit;
        $query = RmeTransferPasienAntarRuang::with(['userCreate', 'serahTerima'])
            // where data medis ok
            ->where(function ($q) use ($dataMedis) {
                $q->where('kd_unit', $dataMedis->kd_unit)
                    ->whereDate('tgl_masuk', $dataMedis->tgl_masuk)
                    ->where('urut_masuk', $dataMedis->urut_masuk);
            })
            // where data medis asal
            ->orWhere(function ($q) use ($dataMedisAsal, $kdUnit) {
                $q->where('kd_unit', $dataMedisAsal->kd_unit)
                    ->whereDate('tgl_masuk', $dataMedisAsal->tgl_masuk)
                    ->where('urut_masuk', $dataMedisAsal->urut_masuk)
                    ->whereHas('serahTerima', function ($q) use ($kdUnit) {
                        $q->where('kd_unit_tujuan', $kdUnit);
                    });
            })
            ->where('kd_pasien', $dataMedis->kd_pasien);

        // Pencarian berdasarkan nama dokter
        if ($search = $request->query('search')) {
            $query->whereHas('userCreate', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan tanggal
        if ($start_date = $request->query('start_date')) {
            $query->whereDate('tanggal', '>=', $start_date);
        }
        if ($end_date = $request->query('end_date')) {
            $query->whereDate('tanggal', '<=', $end_date);
        }

        // Ambil data dengan pagination, urutkan berdasarkan tanggal
        $transfers = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam', 'desc')
            ->paginate(10);

        $unit = Unit::where('aktif', 1)->get();

        $unitTujuan = Unit::where('kd_bagian', 1)
            ->where('aktif', 1)
            ->get();

        $petugas = HrdKaryawan::where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->where('status_peg', 1)
            ->get();

        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        return view('unit-pelayanan.operasi.pelayanan.transfer.index', compact(
            'dataMedis',
            'transfers',
            'unit',
            'unitTujuan',
            'petugas',
            'dokter',
            'alergiPasien'
        ));
    }

    public function create($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        // get order OK
        $order = OrderOK::where('kd_kasir_ok', $dataMedis->kd_kasir)
            ->where('no_transaksi_ok', $dataMedis->no_transaksi)
            ->first();

        if (empty($order)) return back()->with('error', 'Pasien belum memiliki order atau tidak melalui RME saat order !');

        $dataMedisAsal = $this->baseService->getDataMedisbyTransaksi($order->kd_kasir, $order->no_transaksi);

        if (empty($dataMedisAsal)) {
            abort(404, 'Data medis asal not found');
        }

        // Get Pasien Inap Data
        $pasienInap = PasienInap::where('kd_kasir', $dataMedisAsal->kd_kasir)
            ->where('no_transaksi', $dataMedisAsal->no_transaksi)
            ->first();

        $oldUnitInap = $pasienInap->kd_unit;

        $unit = Unit::where('aktif', 1)->get();
        $unitTujuan = Unit::where('kd_unit', $oldUnitInap)->get();

        $petugas = HrdKaryawan::where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->where('status_peg',  1)
            ->get();
        $dokter = Dokter::where('status', 1)->orderBy('nama', 'asc')->get();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        return view('unit-pelayanan.operasi.pelayanan.transfer.create', compact(
            'dataMedis',
            'unit',
            'unitTujuan',
            'petugas',
            'dokter',
            'alergiPasien',
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();

        try {
            // Validasi data
            $validated = $this->validateTransferData($request);

            $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);
            if (empty($dataMedis)) throw new Exception('Data medis tidak ditemukan');

            // get order OK
            $order = OrderOK::where('kd_kasir_ok', $dataMedis->kd_kasir)
                ->where('no_transaksi_ok', $dataMedis->no_transaksi)
                ->first();

            if (empty($order)) throw new Exception('Pasien belum memiliki order atau tidak melalui RME saat order !');

            $dataMedisAsal = $this->baseService->getDataMedisbyTransaksi($order->kd_kasir, $order->no_transaksi);

            if (empty($dataMedisAsal)) {
                abort(404, 'Data medis asal not found');
            }

            // Get Pasien Inap Data
            $pasienInap = PasienInap::where('kd_kasir', $dataMedisAsal->kd_kasir)
                ->where('no_transaksi', $dataMedisAsal->no_transaksi)
                ->first();

            $oldUnitInap = $pasienInap->kd_unit;

            // Prepare data untuk disimpan
            $transferData = $this->prepareTransferData($validated, $this->kdUnit, $dataMedis->kd_pasien, $dataMedis->tgl_masuk, $dataMedis->urut_masuk);
            // Simpan data
            $transfer = RmeTransferPasienAntarRuang::create($transferData);

            // Validasi data alergi
            $alergiData = json_decode($request->alergis, true);

            if (!empty($alergiData)) {
                // Hapus data alergi lama untuk pasien ini
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

                // Simpan data alergi baru
                foreach ($alergiData as $alergi) {
                    // Skip data yang sudah ada di database (is_existing = true)
                    // kecuali jika ingin update
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            }

            // CREATE DATA SERAH TERIMA
            $handOverData = [
                'kd_pasien'             => $dataMedis->kd_pasien,
                'tgl_masuk'             => $dataMedis->tgl_masuk,
                'urut_masuk'            => $dataMedis->urut_masuk,
                'kd_unit_asal'          => $this->kdUnit,
                'kd_unit_tujuan'        => $oldUnitInap,
                'petugas_menyerahkan'   => $request->petugas_menyerahkan,
                'tanggal_menyerahkan'   => $request->tanggal_menyerahkan,
                'jam_menyerahkan'       => $request->jam_menyerahkan,
                'transfer_id'           => $transfer->id ?? null,
                'status'                => 1,
                'kd_kasir_asal'         => $dataMedis->kd_kasir,
                'no_transaksi_asal'     => $dataMedis->no_transaksi
            ];

            RmeSerahTerima::create($handOverData);

            DB::commit();

            return to_route('operasi.pelayanan.transfer-pasien.index', [
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
            ])->with('success', 'Data transfer pasien berhasil disimpan.');
        } catch (ValidationException $e) {
            DB::rollback();
            return back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $transfer = RmeTransferPasienAntarRuang::findOrFail($id);

        $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);
        if (!$dataMedis) {
            abort(404, 'Data medis not found');
        }

        $petugas = HrdKaryawan::where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->where('status_peg', 1)
            ->get();
        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        // Decode JSON fields
        $transfer = $this->decodeJsonFields($transfer);

        return view('unit-pelayanan.operasi.pelayanan.transfer.show', compact('transfer', 'dataMedis', 'petugas', 'dokter', 'alergiPasien'));
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $transfer = RmeTransferPasienAntarRuang::with(['serahTerima'])->where('id', $id)->first();
        if (!$transfer) {
            abort(404, 'Data transfer not found');
        }

        $dataMedis = $this->baseService->getDataMedis($this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk);

        if (!$dataMedis) {
            abort(404, 'Data medis not found');
        }

        $petugas = HrdKaryawan::where('kd_jenis_tenaga', 2)
            ->where('kd_detail_jenis_tenaga', 1)
            ->where('status_peg', 1)
            ->get();
        $dokter = Dokter::where('status', 1)->orderBy('nama_lengkap', 'asc')->get();
        $alergiPasien = RmeAlergiPasien::where('kd_pasien', $kd_pasien)->get();

        // Decode JSON fields
        $transfer = $this->decodeJsonFields($transfer);

        return view('unit-pelayanan.operasi.pelayanan.transfer.edit', compact('transfer', 'dataMedis', 'petugas', 'dokter', 'alergiPasien'));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();

        try {

            $transfer = RmeTransferPasienAntarRuang::findOrFail($id);

            // Validasi data
            $validated = $this->validateTransferData($request);

            // Prepare data untuk update
            $transferData = $this->prepareTransferData($validated, $this->kdUnit, $kd_pasien, $tgl_masuk, $urut_masuk, true);

            // Update data
            $transfer->update($transferData);
            // Update data alergi
            $alergiData = json_decode($request->alergis, true);

            if (!empty($alergiData)) {
                // Hapus data alergi lama untuk pasien ini
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();

                // Simpan data alergi baru
                foreach ($alergiData as $alergi) {
                    RmeAlergiPasien::create([
                        'kd_pasien' => $kd_pasien,
                        'jenis_alergi' => $alergi['jenis_alergi'],
                        'nama_alergi' => $alergi['alergen'],
                        'reaksi' => $alergi['reaksi'],
                        'tingkat_keparahan' => $alergi['tingkat_keparahan']
                    ]);
                }
            } else {
                // Jika tidak ada data alergi baru, hapus yang lama
                RmeAlergiPasien::where('kd_pasien', $kd_pasien)->delete();
            }

            DB::commit();

            return redirect()->route('operasi.pelayanan.transfer-pasien.index', [
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk,
            ])->with('success', 'Data transfer pasien berhasil diperbarui.');
        } catch (ValidationException $e) {
            DB::rollback();
            return back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        try {
            $transfer = RmeTransferPasienAntarRuang::findOrFail($id);
            $transfer->delete();

            return redirect()->route('operasi.pelayanan.transfer-pasien.index', [
                $kd_pasien,
                $tgl_masuk,
                $urut_masuk
            ])->with('success', 'Data transfer pasien berhasil dihapus.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    /**
     * Validate transfer data
     */
    private function validateTransferData(Request $request)
    {
        return $request->validate([
            // Unit dan Kamar
            'kd_unit_tujuan' => 'nullable|string',

            // Petugas yang menyerahkan
            'petugas_menyerahkan' => 'nullable|string',
            'tanggal_menyerahkan' => 'nullable|date',
            'jam_menyerahkan' => 'nullable',

            // Informasi Medis
            'dokter_merawat' => 'nullable|string',
            'dpjp' => 'nullable|string',
            'diagnosis_utama' => 'nullable|string',
            'diagnosis_sekunder' => 'nullable|string',
            'mrsa' => 'nullable|string',
            'lainnya_perhatian' => 'nullable|string',

            // Persetujuan
            'persetujuan' => 'required|in:ya,tidak',
            'nama_keluarga' => 'nullable|string',
            'hubungan_keluarga' => 'nullable|string',

            // Alasan pemindahan
            'alasan' => 'nullable|array',
            'lainnya_alasan_detail' => 'nullable|string',

            // Metode pemindahan
            'metode' => 'nullable|array',

            // Keadaan pasien
            'keadaan_umum' => 'nullable|string',
            'kesadaran' => 'nullable|string',
            'tekanan_darah_sistole' => 'nullable|integer',
            'tekanan_darah_diastole' => 'nullable|integer',
            'nadi' => 'nullable|integer',
            'suhu' => 'nullable|numeric',
            'resp' => 'nullable|integer',
            'status_nyeri' => 'nullable|string',

            // Informasi medis dan peralatan
            'info_medis' => 'nullable|array',
            'info_medis_lainnya' => 'nullable|string',
            'peralatan' => 'nullable|array',
            'o2_kebutuhan' => 'nullable|string',
            'peralatan_lainnya' => 'nullable|string',

            // Gangguan dan inkontinensia
            'gangguan' => 'nullable|array',
            'gangguan_lainnya' => 'nullable|string',
            'inkontinensia' => 'nullable|array',
            'inkontinensia_lainnya' => 'nullable|string',
            'rehabilitasi' => 'nullable|string',
            'rehabilitasi_lainnya' => 'nullable|string',

            // Petugas pendamping
            'petugas1' => 'nullable|string',
            'petugas2' => 'nullable|string',
            'petugas3' => 'nullable|string',

            // Pemeriksaan fisik
            'status_generalis' => 'nullable|string',
            'status_lokalis' => 'nullable|string',

            // Status kemandirian
            'berguling' => 'nullable|string',
            'duduk' => 'nullable|string',
            'higiene_wajah' => 'nullable|string',
            'higiene_tubuh' => 'nullable|string',
            'higiene_ekstremitas_bawah' => 'nullable|string',
            'traktus_digestivus' => 'nullable|string',
            'traktus_urinarius' => 'nullable|string',
            'pakaian_atas' => 'nullable|string',
            'pakaian_tubuh' => 'nullable|string',
            'pakaian_bawah' => 'nullable|string',
            'makan' => 'nullable|string',
            'jalan_kaki' => 'nullable|string',
            'kursi_roda' => 'nullable|string',

            // Rencana perawatan
            'pemeriksaan_penunjang' => 'nullable|string',
            'intervensi' => 'nullable|string',
            'diet' => 'nullable|string',
            'rencana_perawatan' => 'nullable|string',

            // Terapi dan derajat pasien
            'terapi_data' => 'nullable|json',
            'derajat_pasien' => 'nullable|string',
        ]);
    }

    /**
     * Prepare data untuk disimpan ke database
     */
    private function prepareTransferData($validated, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk, $isUpdate = false)
    {
        $data = [
            'kd_pasien' => $kd_pasien,
            'kd_unit' => $kd_unit,
            'tgl_masuk' => $tgl_masuk,
            'urut_masuk' => $urut_masuk,
            'tanggal' => $validated['tanggal_menyerahkan'],
            'jam' => $validated['jam_menyerahkan'],
            'dokter_merawat' => $validated['dokter_merawat'] ?? null,
            'diagnosis_utama' => $validated['diagnosis_utama'] ?? null,
            'diagnosis_sekunder' => $validated['diagnosis_sekunder'] ?? null,
            'dpjp' => $validated['dpjp'] ?? null,
            'mrsa' => $validated['mrsa'] ?? null,
            'lainnya_perhatian' => $validated['lainnya_perhatian'] ?? null,
            'persetujuan' => $validated['persetujuan'],
            'nama_keluarga' => $validated['nama_keluarga'] ?? null,
            'hubungan_keluarga' => $validated['hubungan_keluarga'] ?? null,
            'keadaan_umum' => $validated['keadaan_umum'] ?? null,
            'kesadaran' => $validated['kesadaran'],
            'tekanan_darah_sistole' => $validated['tekanan_darah_sistole'],
            'tekanan_darah_diastole' => $validated['tekanan_darah_diastole'],
            'nadi' => $validated['nadi'],
            'suhu' => $validated['suhu'],
            'resp' => $validated['resp'],
            'status_nyeri' => $validated['status_nyeri'],
            'rehabilitasi' => $validated['rehabilitasi'] ?? null,
            'rehabilitasi_lainnya' => $validated['rehabilitasi_lainnya'] ?? null,
            'petugas1' => $validated['petugas1'] ?? null,
            'petugas2' => $validated['petugas2'] ?? null,
            'petugas3' => $validated['petugas3'] ?? null,
            'status_generalis' => $validated['status_generalis'] ?? null,
            'status_lokalis' => $validated['status_lokalis'] ?? null,
            'berguling' => $validated['berguling'] ?? null,
            'duduk' => $validated['duduk'] ?? null,
            'higiene_wajah' => $validated['higiene_wajah'] ?? null,
            'higiene_tubuh' => $validated['higiene_tubuh'] ?? null,
            'higiene_ekstremitas_bawah' => $validated['higiene_ekstremitas_bawah'] ?? null,
            'traktus_digestivus' => $validated['traktus_digestivus'] ?? null,
            'traktus_urinarius' => $validated['traktus_urinarius'] ?? null,
            'pakaian_atas' => $validated['pakaian_atas'] ?? null,
            'pakaian_tubuh' => $validated['pakaian_tubuh'] ?? null,
            'pakaian_bawah' => $validated['pakaian_bawah'] ?? null,
            'makan' => $validated['makan'] ?? null,
            'jalan_kaki' => $validated['jalan_kaki'] ?? null,
            'kursi_roda' => $validated['kursi_roda'] ?? null,
            'pemeriksaan_penunjang' => $validated['pemeriksaan_penunjang'] ?? null,
            'intervensi' => $validated['intervensi'] ?? null,
            'diet' => $validated['diet'] ?? null,
            'rencana_perawatan' => $validated['rencana_perawatan'] ?? null,
            'derajat_pasien' => $validated['derajat_pasien'],
            'to_penunjang' => 1
        ];

        // Handle JSON fields
        $jsonFields = [
            'alasan' => $validated['alasan'] ?? [],
            'lainnya_alasan_detail' => $validated['lainnya_alasan_detail'] ?? null,
            'metode' => $validated['metode'] ?? [],
            'info_medis' => $validated['info_medis'] ?? [],
            'info_medis_lainnya' => $validated['info_medis_lainnya'] ?? null,
            'peralatan' => $validated['peralatan'] ?? [],
            'o2_kebutuhan' => $validated['o2_kebutuhan'] ?? null,
            'peralatan_lainnya' => $validated['peralatan_lainnya'] ?? null,
            'gangguan' => $validated['gangguan'] ?? [],
            'gangguan_lainnya' => $validated['gangguan_lainnya'] ?? null,
            'inkontinensia' => $validated['inkontinensia'] ?? [],
            'inkontinensia_lainnya' => $validated['inkontinensia_lainnya'] ?? null,
        ];

        foreach ($jsonFields as $field => $value) {
            if (in_array($field, ['alasan', 'metode', 'info_medis', 'peralatan', 'gangguan', 'inkontinensia'])) {
                $data[$field] = json_encode($value);
            } else {
                $data[$field] = $value;
            }
        }

        // Handle terapi data
        if (!empty($validated['terapi_data'])) {
            $data['terapi_data'] = $validated['terapi_data'];
        } else {
            $data['terapi_data'] = json_encode([]);
        }

        // Handle alergi data
        if (!empty($validated['alergis'])) {
            $data['alergis'] = $validated['alergis'];
        } else {
            $data['alergis'] = json_encode([]);
        }

        // Set user info
        if (!$isUpdate) {
            $data['user_create'] = auth()->id();
        }
        $data['user_edit'] = auth()->id();

        return $data;
    }

    /**
     * Decode JSON fields untuk tampilan
     */
    private function decodeJsonFields($transfer)
    {
        $jsonFields = ['alasan', 'metode', 'info_medis', 'peralatan', 'gangguan', 'inkontinensia', 'terapi_data', 'alergis'];

        foreach ($jsonFields as $field) {
            if (isset($transfer->$field)) {
                $decoded = json_decode($transfer->$field, true);
                $transfer->$field = $decoded ?? [];
            }
        }

        return $transfer;
    }

    /**
     * Get available rooms by unit (AJAX)
     */
    public function getKamarByRuang(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            // Validasi input
            $request->validate([
                'kd_unit' => 'required'
            ]);

            $kdUnit = $request->kd_unit;

            // Query untuk mendapatkan kamar yang tersedia
            $kamar = KamarInduk::select([
                'kamar_induk.no_kamar',
                'kamar_induk.nama_kamar',
                DB::raw('(kamar_induk.jumlah_bed - kamar_induk.digunakan - kamar_induk.booking) as sisa_bed')
            ])
                ->join('kamar as k', 'kamar_induk.no_kamar', '=', 'k.no_kamar')
                ->where(DB::raw('(kamar_induk.jumlah_bed - kamar_induk.digunakan - kamar_induk.booking)'), '>', 0)
                ->where('kamar_induk.aktif', 1)
                ->where('k.kd_unit', $kdUnit)
                ->orderBy('kamar_induk.nama_kamar')
                ->get();

            $kamarHtml = "<option value=''>--Pilih Kamar--</option>";

            if ($kamar->count() > 0) {
                foreach ($kamar as $kmr) {
                    $kamarHtml .= "<option value='{$kmr->no_kamar}' data-sisa-bed='{$kmr->sisa_bed}'>{$kmr->nama_kamar} (Sisa: {$kmr->sisa_bed} bed)</option>";
                }
            } else {
                $kamarHtml .= "<option value='' disabled>Tidak ada kamar tersedia</option>";
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'Data kamar berhasil dimuat',
                'data'      => $kamarHtml,
                'count'     => $kamar->count()
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Data tidak valid: ' . implode(', ', $e->errors()),
                'data'      => "<option value=''>--Pilih Kamar--</option>"
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status'    => 'error',
                'message'   => 'Terjadi kesalahan saat mengambil data kamar',
                'data'      => "<option value=''>--Pilih Kamar--</option>"
            ]);
        }
    }


    /**
     * Get remaining beds in a room (AJAX)
     */
    public function getSisaBedByKamar(Request $request, $kd_unit, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        try {
            // Validasi input
            $request->validate([
                'no_kamar' => 'required',
                'kd_unit' => 'required'
            ]);

            $noKamar = $request->no_kamar;
            $kdUnit = $request->kd_unit;

            // Query untuk mendapatkan sisa bed
            $kamarData = KamarInduk::select([
                'kamar_induk.no_kamar',
                'kamar_induk.nama_kamar',
                'kamar_induk.jumlah_bed',
                'kamar_induk.digunakan',
                'kamar_induk.booking',
                DB::raw('(kamar_induk.jumlah_bed - kamar_induk.digunakan - kamar_induk.booking) as sisa_bed')
            ])
                ->join('kamar as k', 'kamar_induk.no_kamar', '=', 'k.no_kamar')
                ->where('kamar_induk.no_kamar', $noKamar)
                ->where('k.kd_unit', $kdUnit)
                ->where('kamar_induk.aktif', 1)
                ->first();

            if (!$kamarData) {
                return response()->json([
                    'status'    => 'error',
                    'message'   => 'Data kamar tidak ditemukan',
                    'data'      => 0
                ]);
            }

            $sisaBed = $kamarData->sisa_bed;

            // Validasi sisa bed tidak boleh negatif
            if ($sisaBed < 0) {
                $sisaBed = 0;
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'Data sisa bed berhasil dimuat',
                'data'      => $sisaBed,
                'detail'    => [
                    'nama_kamar' => $kamarData->nama_kamar,
                    'total_bed' => $kamarData->jumlah_bed,
                    'terpakai' => $kamarData->digunakan,
                    'booking' => $kamarData->booking,
                    'sisa' => $sisaBed
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status'    => 'error',
                'message'   => 'Data tidak valid: ' . implode(', ', $e->errors()),
                'data'      => 0
            ]);
        } catch (Exception $e) {

            return response()->json([
                'status'    => 'error',
                'message'   => 'Terjadi kesalahan saat mengambil data sisa bed',
                'data'      => 0
            ]);
        }
    }

    private function getRiwayatCatatanPemberianObat($kd_pasien, $kd_unit, $tgl_masuk, $urut_masuk)
    {
        $since = now()->subDay();
        return RmeCatatanPemberianObat::where('kd_pasien', $kd_pasien)
            ->where('kd_unit', $kd_unit)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->where('tanggal', '>=', $since)
            ->with(['petugas', 'petugasValidasi'])
            ->select(
                'id',
                'kd_petugas',
                'nama_obat',
                'frekuensi',
                'dosis',
                'satuan',
                'keterangan',
                'freak',
                'tanggal',
                'catatan',
                'is_validasi',
                'petugas_validasi'
            )
            ->orderBy('tanggal', 'desc')
            ->get();
    }
}
