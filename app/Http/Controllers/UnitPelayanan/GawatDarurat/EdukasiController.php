<?php

namespace App\Http\Controllers\UnitPelayanan\GawatDarurat;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use App\Models\EdukasiKebutuhanEdukasi;
use App\Models\EdukasiKebutuhanEdukasiLanjutan;
use App\Models\EdukasiPasien;
use App\Models\Kunjungan;
use App\Models\Pendidikan;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\RMEEdukasiRoles;
use Exception;

class EdukasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read unit-pelayanan/gawat-darurat');
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
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Fetch education data with pagination
        $edukasi = Edukasi::with(['edukasiPasien', 'kebutuhanEdukasi', 'kebutuhanEdukasiLanjutan', 'userCreate'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 3)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $dataMedis->urut_masuk)
            ->orderBy('id', 'desc')
            ->paginate(10);

        // dd($edukasi);

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.edukasi.index', compact(
            'dataMedis',
            'edukasi'
        ));
    }

    public function create($kd_pasien, $tgl_masuk, $urut_masuk, Request $request)
    {
        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $role = $request->query('role', 'admin');

        $sectionAccess = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16];

        if($role == 'dokter') $sectionAccess = [1,2,9,10,13,15,16];
        if($role == 'farmasi') $sectionAccess = [3,15,16];
        if($role == 'gizi') $sectionAccess = [4,15,16];
        if($role == 'perawat') $sectionAccess = [5,6,7,15,16];
        if($role == 'adc') $sectionAccess = [11,12,14,15,16];

        $pendidikan = Pendidikan::all();

        // Cari data edukasi yang sudah ada berdasarkan parameter kunjungan
        $existingEdukasi = Edukasi::with(['edukasiPasien', 'kebutuhanEdukasi', 'kebutuhanEdukasiLanjutan'])
            ->where('kd_pasien', $kd_pasien)
            ->where('kd_unit', 3)
            ->whereDate('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->first();

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.edukasi.create', compact(
            'dataMedis',
            'pendidikan',
            'sectionAccess',
            'role',
            'existingEdukasi',
        ));
    }

    public function store(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        DB::beginTransaction();
        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
                ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
                ->where('kunjungan.kd_unit', 3)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data kunjungan tidak ditemukan');
            }

            $role = $request->role;
            $sectionAccess = $this->getSectionAccess($role);
            
            $edukasi = Edukasi::firstOrCreate([
                'kd_pasien' => $kd_pasien,
                'kd_unit' => 3,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
            ], [
                'waktu_edukasi' => date('Y-m-d H:i:s'),
                'user_create' => Auth::id(),
            ]);

            // UPDATE ROLES - PRESERVE EXISTING DATA
            $this->updateUserRoles($edukasi->id, $sectionAccess, Auth::id());

            $this->updateEdukasiPasien($edukasi->id, $request, $sectionAccess);

            $this->updateKebutuhanEdukasi($edukasi->id, $request, $sectionAccess);

            $this->updateKebutuhanEdukasiLanjutan($edukasi->id, $request, $sectionAccess);

            DB::commit();

            return redirect()->route('edukasi.index', [
                $kd_pasien,
                $tgl_masuk,
                $request->urut_masuk,
            ])->with(['success' => 'Berhasil menambah Edukasi !']);
            
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    private function getSectionAccess($role)
    {
        $sectionAccess = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16];

        if($role == 'dokter') $sectionAccess = [1,2,9,10,13,15,16];
        if($role == 'farmasi') $sectionAccess = [3,15,16];
        if($role == 'gizi') $sectionAccess = [4,15,16];
        if($role == 'perawat') $sectionAccess = [5,6,7,15,16];
        if($role == 'adc') $sectionAccess = [11,12,14,15,16];

        return $sectionAccess;
    }

    private function updateUserRoles($edukasiId, $sectionAccess, $userId)
    {
        $existingRole = RMEEdukasiRoles::where('id_edukasi', $edukasiId)->first();
        
        if ($existingRole) {
            // Update hanya kolom yang sesuai dengan role saat ini
            $updateData = [];
            foreach($sectionAccess as $acc) {
                $updateData["user_edukasi_$acc"] = $userId;
            }
            $existingRole->update($updateData);
        } else {
            // Buat baru
            $dataRole = ['id_edukasi' => $edukasiId];
            foreach($sectionAccess as $acc) {
                $dataRole["user_edukasi_$acc"] = $userId;
            }
            RMEEdukasiRoles::create($dataRole);
        }
    }

    private function updateEdukasiPasien($edukasiId, $request, $sectionAccess)
    {
        $edukasiPasien = EdukasiPasien::firstOrNew(['id_edukasi' => $edukasiId]);
        
        // Hanya update field yang ada di section access role ini
        // Untuk EdukasiPasien, biasanya semua role bisa akses basic info
        if ($request->has('kebutuhan_penerjemah')) {
            $edukasiPasien->kebutuhan_penerjemah = $request->kebutuhan_penerjemah;
        }
        if ($request->has('penerjemah_bahasa')) {
            $edukasiPasien->penerjemah_bahasa = $request->penerjemah_bahasa;
        }
        if ($request->has('pendidikan')) {
            $edukasiPasien->pendidikan = $request->pendidikan;
        }
        if ($request->has('kemampuan_baca_tulis')) {
            $edukasiPasien->kemampuan_baca_tulis = $request->kemampuan_baca_tulis;
        }
        if ($request->has('tipe_pembelajaran')) {
            $edukasiPasien->tipe_pembelajaran = json_encode($request->tipe_pembelajaran);
        }
        if ($request->has('hambatan_komunikasi')) {
            $edukasiPasien->hambatan_komunikasi = json_encode($request->hambatan_komunikasi);
        }
        
        $edukasiPasien->save();
    }

    private function updateKebutuhanEdukasi($edukasiId, $request, $sectionAccess)
    {
        $kebutuhanEdukasi = EdukasiKebutuhanEdukasi::firstOrNew(['id_edukasi' => $edukasiId]);
        
        // Update hanya field yang accessible oleh role ini
        for ($i = 1; $i <= 6; $i++) {
            if (in_array($i, $sectionAccess)) {
                // Update field untuk section ini
                if ($request->has("tanggal_$i")) {
                    $kebutuhanEdukasi->{"tanggal_$i"} = $request->{"tanggal_$i"};
                }
                if ($request->has("ket_Kondisi_medis_$i")) {
                    $kebutuhanEdukasi->{"ket_Kondisi_medis_$i"} = $request->{"ket_Kondisi_medis_$i"};
                }
                if ($request->has("ket_program_$i")) {
                    $kebutuhanEdukasi->{"ket_program_$i"} = $request->{"ket_program_$i"};
                }
                if ($request->has("sasaran_nama_$i")) {
                    $kebutuhanEdukasi->{"sasaran_nama_$i"} = $request->{"sasaran_nama_$i"};
                }
                if ($request->has("edukator_nama_$i")) {
                    $kebutuhanEdukasi->{"edukator_nama_$i"} = $request->{"edukator_nama_$i"};
                }
                if ($request->has("pemahaman_awal_$i")) {
                    $kebutuhanEdukasi->{"pemahaman_awal_$i"} = json_encode($request->{"pemahaman_awal_$i"});
                }
                if ($request->has("metode_$i")) {
                    $kebutuhanEdukasi->{"metode_$i"} = json_encode($request->{"metode_$i"});
                }
                if ($request->has("media_$i")) {
                    $kebutuhanEdukasi->{"media_$i"} = json_encode($request->{"media_$i"});
                }
                if ($request->has("evaluasi_$i")) {
                    $kebutuhanEdukasi->{"evaluasi_$i"} = json_encode($request->{"evaluasi_$i"});
                }
                if ($request->has("lama_edukasi_$i")) {
                    $kebutuhanEdukasi->{"lama_edukasi_$i"} = $request->{"lama_edukasi_$i"};
                }
            }
        }
        
        $kebutuhanEdukasi->save();
    }

    private function updateKebutuhanEdukasiLanjutan($edukasiId, $request, $sectionAccess)
    {
        $kebutuhanEdukasiLanjutan = EdukasiKebutuhanEdukasiLanjutan::firstOrNew(['id_edukasi' => $edukasiId]);
        
        // Update hanya field yang accessible oleh role ini
        for ($i = 7; $i <= 16; $i++) {
            if (in_array($i, $sectionAccess)) {
                // Update field untuk section ini
                if ($request->has("tanggal_$i")) {
                    $kebutuhanEdukasiLanjutan->{"tanggal_$i"} = $request->{"tanggal_$i"};
                }
                if ($request->has("sasaran_nama_$i")) {
                    $kebutuhanEdukasiLanjutan->{"sasaran_nama_$i"} = $request->{"sasaran_nama_$i"};
                }
                if ($request->has("edukator_nama_$i")) {
                    $kebutuhanEdukasiLanjutan->{"edukator_nama_$i"} = $request->{"edukator_nama_$i"};
                }
                
                // Field khusus untuk section tertentu
                if ($i == 9) {
                    if ($request->has("ket_teknik_rehabilitasi_9")) {
                        $kebutuhanEdukasiLanjutan->ket_teknik_rehabilitasi_9 = $request->ket_teknik_rehabilitasi_9;
                    }
                    if ($request->has("teknik_rehabilitasi_9")) {
                        $kebutuhanEdukasiLanjutan->teknik_rehabilitasi_9 = $request->teknik_rehabilitasi_9;
                    }
                }
                if ($i == 14 && $request->has("ket_hambatan_14")) {
                    $kebutuhanEdukasiLanjutan->ket_hambatan_14 = $request->ket_hambatan_14;
                }
                if ($i == 15 && $request->has("ket_pertanyaan_15")) {
                    $kebutuhanEdukasiLanjutan->ket_pertanyaan_15 = $request->ket_pertanyaan_15;
                }
                if ($i == 16 && $request->has("ket_preferensi_16")) {
                    $kebutuhanEdukasiLanjutan->ket_preferensi_16 = $request->ket_preferensi_16;
                }
                
                if ($request->has("pemahaman_awal_$i")) {
                    $kebutuhanEdukasiLanjutan->{"pemahaman_awal_$i"} = json_encode($request->{"pemahaman_awal_$i"});
                }
                if ($request->has("metode_$i")) {
                    $kebutuhanEdukasiLanjutan->{"metode_$i"} = json_encode($request->{"metode_$i"});
                }
                if ($request->has("media_$i")) {
                    $kebutuhanEdukasiLanjutan->{"media_$i"} = json_encode($request->{"media_$i"});
                }
                if ($request->has("evaluasi_$i")) {
                    $kebutuhanEdukasiLanjutan->{"evaluasi_$i"} = json_encode($request->{"evaluasi_$i"});
                }
                if ($request->has("lama_edukasi_$i")) {
                    $kebutuhanEdukasiLanjutan->{"lama_edukasi_$i"} = $request->{"lama_edukasi_$i"};
                }
            }
        }
        
        $kebutuhanEdukasiLanjutan->save();
    }

    public function show($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {

        $edukasi = Edukasi::with([
            'edukasiPasien',
            'kebutuhanEdukasi',
            'kebutuhanEdukasiLanjutan',
            'userCreate',
        ])->findOrFail($id);

        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();


        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Get reference data for display purposes
        $pendidikan = Pendidikan::all();

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.edukasi.show', compact('edukasi', 'pendidikan', 'dataMedis'));
    }

    public function edit($kd_pasien, $tgl_masuk, $urut_masuk, $id, Request $request)
    {
        $edukasi = Edukasi::with([
            'edukasiPasien',
            'kebutuhanEdukasi',
            'kebutuhanEdukasiLanjutan',
            'userCreate',
        ])->findOrFail($id);

        $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
            ->join('transaksi as t', function ($join) {
                $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
            })
            ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
            ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
            ->where('kunjungan.kd_unit', 3)
            ->where('kunjungan.kd_pasien', $kd_pasien)
            ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
            ->where('kunjungan.urut_masuk', $urut_masuk)
            ->first();

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Get role from request, default to admin if not specified
        $role = $request->query('role', 'admin');
        $sectionAccess = $this->getSectionAccess($role);

        // Get reference data for display purposes
        $pendidikan = Pendidikan::all();

        // Set existing edukasi untuk populasi data di form
        $existingEdukasi = $edukasi;

        return view('unit-pelayanan.gawat-darurat.action-gawat-darurat.edukasi.edit', compact(
            'edukasi', 
            'pendidikan', 
            'dataMedis', 
            'role', 
            'sectionAccess', 
            'existingEdukasi'
        ));
    }

    public function update(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();
        try {
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien');
                    $join->on('kunjungan.kd_unit', '=', 't.kd_unit');
                    $join->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi');
                    $join->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
                ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
                ->where('kunjungan.kd_unit', 3)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                abort(404, 'Data kunjungan tidak ditemukan');
            }

            $edukasi = Edukasi::findOrFail($id);
            $edukasi->kd_pasien = $kd_pasien;
            $edukasi->kd_unit = 3;
            $edukasi->tgl_masuk = $tgl_masuk;
            $edukasi->urut_masuk = $urut_masuk;
            $edukasi->waktu_edukasi = date('Y-m-d H:i:s');
            $edukasi->user_edit = Auth::id();
            $edukasi->save();

            $role = $request->role ?? 'admin';
            $sectionAccess = $this->getSectionAccess($role);

            // UPDATE ROLES - PRESERVE EXISTING DATA
            $this->updateUserRoles($edukasi->id, $sectionAccess, Auth::id());

            $this->updateEdukasiPasien($edukasi->id, $request, $sectionAccess);

            $this->updateKebutuhanEdukasi($edukasi->id, $request, $sectionAccess);

            $this->updateKebutuhanEdukasiLanjutan($edukasi->id, $request, $sectionAccess);

            DB::commit();

            return redirect()->route('edukasi.index', [
                $kd_pasien,
                $tgl_masuk,
                $request->urut_masuk,
            ])->with(['success' => 'Berhasil update data Edukasi !']);
            
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        DB::beginTransaction();
        try {
            // Verify Kunjungan exists
            $dataMedis = Kunjungan::with(['pasien', 'dokter', 'customer', 'unit'])
                ->join('transaksi as t', function ($join) {
                    $join->on('kunjungan.kd_pasien', '=', 't.kd_pasien')
                        ->on('kunjungan.kd_unit', '=', 't.kd_unit')
                        ->on('kunjungan.tgl_masuk', '=', 't.tgl_transaksi')
                        ->on('kunjungan.urut_masuk', '=', 't.urut_masuk');
                })
                ->leftJoin('dokter', 'kunjungan.KD_DOKTER', '=', 'dokter.KD_DOKTER')
                ->select('kunjungan.*', 't.*', 'dokter.NAMA as nama_dokter')
                ->where('kunjungan.kd_unit', 3)
                ->where('kunjungan.kd_pasien', $kd_pasien)
                ->whereDate('kunjungan.tgl_masuk', $tgl_masuk)
                ->where('kunjungan.urut_masuk', $urut_masuk)
                ->first();

            if (!$dataMedis) {
                return redirect()->route('edukasi.index', [
                    'kd_pasien' => $kd_pasien,
                    'tgl_masuk' => $tgl_masuk,
                    'urut_masuk' => $urut_masuk,
                ])->with('error', 'Data kunjungan tidak ditemukan.');
            }

            // Find Edukasi
            $edukasi = Edukasi::findOrFail($id);

            // Delete related records
            EdukasiPasien::where('id_edukasi', $edukasi->id)->delete();
            EdukasiKebutuhanEdukasi::where('id_edukasi', $edukasi->id)->delete();
            EdukasiKebutuhanEdukasiLanjutan::where('id_edukasi', $edukasi->id)->delete();

            // Delete Edukasi
            $edukasi->delete();

            DB::commit();
            return redirect()->route('edukasi.index', [
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
            ])->with('success', 'Data edukasi berhasil dihapus!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('edukasi.index', [
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
            ])->with('error', 'Data edukasi tidak ditemukan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('edukasi.index', [
                'kd_pasien' => $kd_pasien,
                'tgl_masuk' => $tgl_masuk,
                'urut_masuk' => $urut_masuk,
            ])->with('error', 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.');
        }
    }
}
