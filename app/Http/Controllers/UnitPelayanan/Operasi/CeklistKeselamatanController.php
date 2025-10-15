<?php

namespace App\Http\Controllers\UnitPelayanan\Operasi;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\DokterAnastesi;
use App\Models\Kunjungan;
use App\Models\OkCeklistKeselamatanSignin;
use App\Models\OkCeklistKeselamatanSignout;
use App\Models\OkCeklistKeselamatanTimeOut;
use App\Models\OkJenisAnastesi;
use App\Models\Perawat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CeklistKeselamatanController extends Controller
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

        // Ambil data Sign In
        $signin = OkCeklistKeselamatanSignin::where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('waktu_signin', 'desc')
            ->with('dokterAnestesi.dokter:kd_dokter,nama_lengkap', 'perawatData:kd_perawat,nama')
            ->first();

        // Ambil data Time Out
        $timeout = OkCeklistKeselamatanTimeout::where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('waktu_timeout', 'desc')
            ->with('dokterBedah:kd_dokter,nama_lengkap', 'dokterAnastesi.dokter:kd_dokter,nama_lengkap', 'perawatData:kd_perawat,nama')
            ->first();

        // Ambil data Sign Out
        $signout = OkCeklistKeselamatanSignOut::where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('waktu_signout', 'desc')
            ->with('dokterBedah:kd_dokter,nama_lengkap', 'dokterAnastesi.dokter:kd_dokter,nama_lengkap', 'perawatData:kd_perawat,nama')
            ->first();

        return view('unit-pelayanan.operasi.pelayanan.ceklist-keselamatan.index', compact(
            'dataMedis',
            'signin',
            'timeout',
            'signout',
        ));
    }

    //fungsi print
    public function print($kd_pasien, $tgl_masuk, $urut_masuk)
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

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        // Ambil data Sign In
        $signInList = OkCeklistKeselamatanSignin::where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('waktu_signin', 'desc')
            ->get();

        // Ambil data Time Out
        $timeoutList = OkCeklistKeselamatanTimeout::where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('waktu_timeout', 'desc')
            ->get();

        // Ambil data Sign Out
        $signoutList = OkCeklistKeselamatanSignout::where('kd_pasien', $kd_pasien)
            ->where('tgl_masuk', $tgl_masuk)
            ->where('urut_masuk', $urut_masuk)
            ->orderBy('waktu_signout', 'desc')
            ->get();

        // Load relasi
        $signInList->load([
            'dokterAnestesi' => function ($query) {
                $query->with('dokter');
            },
            'perawatData'
        ]);

        $timeoutList->load([
            'dokterBedah',
            'dokterAnastesi' => function ($query) {
                $query->with('dokter');
            },
            'perawatData'
        ]);

        $signoutList->load([
            'dokterBedah',
            'dokterAnastesi' => function ($query) {
                $query->with('dokter');
            },
            'perawatData'
        ]);

        // Periksa jika semua data tersedia
        if ($signInList->isEmpty() || $timeoutList->isEmpty() || $signoutList->isEmpty()) {
            return redirect()->route('operasi.pelayanan.ceklist-keselamatan.index', [$kd_pasien, $tgl_masuk, $urut_masuk])
                ->with('error', 'Semua checklist (Sign In, Time Out, Sign Out) harus diisi untuk mencetak.');
        }

        return view('unit-pelayanan.operasi.pelayanan.ceklist-keselamatan.print', compact(
            'dataMedis',
            'signInList',
            'timeoutList',
            'signoutList'
        ));
    }



    // Fungsi untuk membuat Sign In
    public function createSignin($kd_pasien, $tgl_masuk, $urut_masuk)
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

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $jenisAnastesi = OkJenisAnastesi::all();
        $dokterAnastesi = DokterAnastesi::all();
        $dokter = Dokter::where('status', 1)->get();
        $perawat = Perawat::where('aktif', 1)->get();


        return view('unit-pelayanan.operasi.pelayanan.ceklist-keselamatan.create-signin', compact('dataMedis', 'jenisAnastesi', 'dokterAnastesi', 'dokter', 'perawat'));
    }

    public function storeSignin(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {

        // dd($request->all());
        // Validate the request
        $request->validate([
            'dokter_anastesi' => 'required',
            'perawat' => 'required',
            'tgl_signin' => 'required|date',
            'jam_signin' => 'required',
            'identifikasi' => 'required|boolean',
            'lokasi' => 'required|boolean',
            'prosedur' => 'required|boolean',
            'informed_anestesi' => 'required|boolean',
            'informed_operasi' => 'required|boolean',
            'tanda_lokasi' => 'required|boolean',
            'mesin_obat' => 'required|boolean',
            'pulse_oximeter' => 'required|boolean',
            'kesulitan_bernafas' => 'required|boolean',
            'resiko_darah' => 'required|boolean',
            'akses_intravena' => 'required|boolean',
        ]);

        // Combine date and time for waktu_signin
        $waktuSignin = Carbon::parse($request->tgl_signin . ' ' . $request->jam_signin);

        // Create new record
        $checklist = new OkCeklistKeselamatanSignin();
        $checklist->kd_pasien = $kd_pasien;
        $checklist->urut_masuk = $urut_masuk;
        $checklist->tgl_masuk = $tgl_masuk;
        $checklist->ahli_anastesi = $request->dokter_anastesi;
        $checklist->perawat = $request->perawat;
        $checklist->waktu_signin = $waktuSignin;
        $checklist->identifikasi = $request->identifikasi;
        $checklist->lokasi = $request->lokasi;
        $checklist->prosedur = $request->prosedur;
        $checklist->informed_anestesi = $request->informed_anestesi;
        $checklist->informed_operasi = $request->informed_operasi;
        $checklist->tanda_lokasi = $request->tanda_lokasi;
        $checklist->mesin_obat = $request->mesin_obat;
        $checklist->pulse_oximeter = $request->pulse_oximeter;
        $checklist->kesulitan_bernafas = $request->kesulitan_bernafas;
        $checklist->resiko_darah = $request->resiko_darah;
        $checklist->akses_intravena = $request->akses_intravena;
        $checklist->user_create = auth()->user()->id;
        $checklist->save();

        return redirect()->route('operasi.pelayanan.ceklist-keselamatan.index', [
            $kd_pasien,
            $tgl_masuk,
            $urut_masuk
        ])->with('success', 'Checklist Sign In berhasil disimpan! Siap operasi!');
    }

    public function editSignin($kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        $signin = OkCeklistKeselamatanSignin::findOrFail($id);
        $jenisAnastesi = OkJenisAnastesi::all();
        $dokterAnastesi = DokterAnastesi::all();
        $dokter = Dokter::where('status', 1)->get();
        $perawat = Perawat::where('aktif', 1)->get();

        return view('unit-pelayanan.operasi.pelayanan.ceklist-keselamatan.edit-signin', compact(
            'dataMedis',
            'signin',
            'jenisAnastesi',
            'dokterAnastesi',
            'dokter',
            'perawat'
        ));
    }

    public function updateSignin(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Validasi request
        $request->validate([
            'dokter_anastesi' => 'required',
            'perawat' => 'required',
            'tgl_signin' => 'required|date',
            'jam_signin' => 'required',
            'identifikasi' => 'required|boolean',
            'lokasi' => 'required|boolean',
            'prosedur' => 'required|boolean',
            'informed_anestesi' => 'required|boolean',
            'informed_operasi' => 'required|boolean',
            'tanda_lokasi' => 'required|boolean',
            'mesin_obat' => 'required|boolean',
            'pulse_oximeter' => 'required|boolean',
            'kesulitan_bernafas' => 'required|boolean',
            'resiko_darah' => 'required|boolean',
            'akses_intravena' => 'required|boolean',
        ]);

        // Cari data yang akan diupdate
        $signin = OkCeklistKeselamatanSignin::findOrFail($id);

        // Gabungkan tanggal dan waktu untuk waktu_signin
        $waktuSignin = Carbon::parse($request->tgl_signin . ' ' . $request->jam_signin);

        // Update record
        $signin->ahli_anastesi = $request->dokter_anastesi;
        $signin->perawat = $request->perawat;
        $signin->waktu_signin = $waktuSignin;
        $signin->identifikasi = $request->identifikasi;
        $signin->lokasi = $request->lokasi;
        $signin->prosedur = $request->prosedur;
        $signin->informed_anestesi = $request->informed_anestesi;
        $signin->informed_operasi = $request->informed_operasi;
        $signin->tanda_lokasi = $request->tanda_lokasi;
        $signin->mesin_obat = $request->mesin_obat;
        $signin->pulse_oximeter = $request->pulse_oximeter;
        $signin->kesulitan_bernafas = $request->kesulitan_bernafas;
        $signin->resiko_darah = $request->resiko_darah;
        $signin->akses_intravena = $request->akses_intravena;
        $signin->user_update = auth()->user()->id;
        $signin->save();

        return redirect()->route('operasi.pelayanan.ceklist-keselamatan.index', [
            $kd_pasien,
            $tgl_masuk,
            $urut_masuk
        ])->with('success', 'Checklist Sign In berhasil diperbarui!');
    }

    public function destroySignin($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $timeout = OkCeklistKeselamatanSignin::findOrFail($id);
        $timeout->delete();

        return redirect()->route('operasi.pelayanan.ceklist-keselamatan.index', [
            $kd_pasien,
            $tgl_masuk,
            $urut_masuk
        ])->with('success', 'Checklist Time Out berhasil dihapus!');
    }


    // Fungsi untuk membuat timeout
    public function createTimeout($kd_pasien, $tgl_masuk, $urut_masuk)
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

        // Menghitung umur berdasarkan tgl_lahir jika ada
        if ($dataMedis->pasien && $dataMedis->pasien->tgl_lahir) {
            $dataMedis->pasien->umur = Carbon::parse($dataMedis->pasien->tgl_lahir)->age;
        } else {
            $dataMedis->pasien->umur = 'Tidak Diketahui';
        }

        if (!$dataMedis) {
            abort(404, 'Data not found');
        }

        $jenisAnastesi = OkJenisAnastesi::all();
        $dokterAnastesi = DokterAnastesi::all();
        $dokter = Dokter::where('status', 1)->get();
        $perawat = Perawat::where('aktif', 1)->get();


        return view('unit-pelayanan.operasi.pelayanan.ceklist-keselamatan.create-timeout', compact('dataMedis', 'jenisAnastesi', 'dokterAnastesi', 'dokter', 'perawat'));
    }

    public function storeTimeout(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Validasi request
        $request->validate([
            'ahli_bedah' => 'required',
            'dokter_anastesi' => 'required',
            'perawat' => 'required',
            'tgl_timeout' => 'required|date',
            'jam_timeout' => 'required',
            'konfirmasi_tim' => 'required|boolean',
            'konfirmasi_nama' => 'required|boolean',
            'konfirmasi_prosedur' => 'required|boolean',
            'konfirmasi_lokasi' => 'required|boolean',
            'antibiotik_profilaksis' => 'required|boolean',
            'nama_antibiotik' => 'nullable|string',
            'dosis_antibiotik' => 'nullable|string',
            'review_bedah' => 'nullable|string',
            'review_anastesi' => 'nullable|string',
            'review_perawat' => 'nullable|string',
            'foto_rontgen' => 'required|boolean',
        ]);

        // Gabungkan tanggal dan waktu untuk waktu_timeout
        $waktuTimeout = Carbon::parse($request->tgl_timeout . ' ' . $request->jam_timeout);

        // Buat record baru
        $timeout = new OkCeklistKeselamatanTimeOut();
        $timeout->kd_pasien = $kd_pasien;
        $timeout->urut_masuk = $urut_masuk;
        $timeout->tgl_masuk = $tgl_masuk;
        $timeout->ahli_bedah = $request->ahli_bedah;
        $timeout->ahli_anastesi = $request->dokter_anastesi;
        $timeout->perawat = $request->perawat;
        $timeout->waktu_timeout = $waktuTimeout;
        $timeout->konfirmasi_tim = $request->konfirmasi_tim;
        $timeout->konfirmasi_nama = $request->konfirmasi_nama;
        $timeout->konfirmasi_prosedur = $request->konfirmasi_prosedur;
        $timeout->konfirmasi_lokasi = $request->konfirmasi_lokasi;
        $timeout->antibiotik_profilaksis = $request->antibiotik_profilaksis;
        $timeout->nama_antibiotik = $request->nama_antibiotik;
        $timeout->dosis_antibiotik = $request->dosis_antibiotik;
        $timeout->review_bedah = $request->review_bedah;
        $timeout->review_anastesi = $request->review_anastesi;
        $timeout->review_perawat = $request->review_perawat;
        $timeout->foto_rontgen = $request->foto_rontgen;
        $timeout->user_create = auth()->user()->id;
        $timeout->save();

        return redirect()->route('operasi.pelayanan.ceklist-keselamatan.index', [
            $kd_pasien,
            $tgl_masuk,
            $urut_masuk
        ])->with('success', 'Checklist Time Out berhasil disimpan!');
    }

    public function editTimeout($kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        $timeout = OkCeklistKeselamatanTimeout::findOrFail($id);
        $jenisAnastesi = OkJenisAnastesi::all();
        $dokterAnastesi = DokterAnastesi::all();
        $dokter = Dokter::where('status', 1)->get();
        $perawat = Perawat::where('aktif', 1)->get();

        return view('unit-pelayanan.operasi.pelayanan.ceklist-keselamatan.edit-timeout', compact(
            'dataMedis',
            'timeout',
            'jenisAnastesi',
            'dokterAnastesi',
            'dokter',
            'perawat'
        ));
    }

    public function updateTimeout(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Validasi request
        $request->validate([
            'ahli_bedah' => 'required',
            'dokter_anastesi' => 'required',
            'perawat' => 'required',
            'tgl_timeout' => 'required|date',
            'jam_timeout' => 'required',
            'konfirmasi_tim' => 'required|boolean',
            'konfirmasi_nama' => 'required|boolean',
            'konfirmasi_prosedur' => 'required|boolean',
            'konfirmasi_lokasi' => 'required|boolean',
            'antibiotik_profilaksis' => 'required|boolean',
            'nama_antibiotik' => 'nullable|string',
            'dosis_antibiotik' => 'nullable|string',
            'review_bedah' => 'nullable|string',
            'review_anastesi' => 'nullable|string',
            'review_perawat' => 'nullable|string',
            'foto_rontgen' => 'required|boolean',
        ]);

        // Cari data yang akan diupdate
        $timeout = OkCeklistKeselamatanTimeOut::findOrFail($id);

        // Gabungkan tanggal dan waktu untuk waktu_timeout
        $waktuTimeout = Carbon::parse($request->tgl_timeout . ' ' . $request->jam_timeout);

        // Update record
        $timeout->ahli_bedah = $request->ahli_bedah;
        $timeout->ahli_anastesi = $request->dokter_anastesi;
        $timeout->perawat = $request->perawat;
        $timeout->waktu_timeout = $waktuTimeout;
        $timeout->konfirmasi_tim = $request->konfirmasi_tim;
        $timeout->konfirmasi_nama = $request->konfirmasi_nama;
        $timeout->konfirmasi_prosedur = $request->konfirmasi_prosedur;
        $timeout->konfirmasi_lokasi = $request->konfirmasi_lokasi;
        $timeout->antibiotik_profilaksis = $request->antibiotik_profilaksis;
        $timeout->nama_antibiotik = $request->nama_antibiotik;
        $timeout->dosis_antibiotik = $request->dosis_antibiotik;
        $timeout->review_bedah = $request->review_bedah;
        $timeout->review_anastesi = $request->review_anastesi;
        $timeout->review_perawat = $request->review_perawat;
        $timeout->foto_rontgen = $request->foto_rontgen;
        $timeout->user_update = auth()->user()->id;
        $timeout->save();

        return redirect()->route('operasi.pelayanan.ceklist-keselamatan.index', [
            $kd_pasien,
            $tgl_masuk,
            $urut_masuk
        ])->with('success', 'Checklist Time Out berhasil diperbarui!');
    }

    public function destroyTimeout($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $timeout = OkCeklistKeselamatanTimeout::findOrFail($id);
        $timeout->delete();

        return redirect()->route('operasi.pelayanan.ceklist-keselamatan.index', [
            $kd_pasien,
            $tgl_masuk,
            $urut_masuk
        ])->with('success', 'Checklist Time Out berhasil dihapus!');
    }


    // Fungsi untuk memperbarui Sign Out
    public function createSignout($kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Ambil data medis pasien
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

        // Ambil data yang diperlukan untuk form
        $jenisAnastesi = OkJenisAnastesi::all();
        $dokterAnastesi = DokterAnastesi::all();
        $dokter = Dokter::where('status', 1)->get();
        $perawat = Perawat::where('aktif', 1)->get();

        return view('unit-pelayanan.operasi.pelayanan.ceklist-keselamatan.create-signout', compact(
            'dataMedis',
            'jenisAnastesi',
            'dokterAnastesi',
            'dokter',
            'perawat'
        ));
    }

    public function storeSignout(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk)
    {
        // Validasi request
        $request->validate([
            'ahli_bedah' => 'required',
            'dokter_anastesi' => 'required',
            'perawat' => 'required',
            'tgl_signout' => 'required|date',
            'jam_signout' => 'required',
            'konfirmasi_prosedur' => 'required|boolean',
            'konfirmasi_instrumen' => 'required|boolean',
            'konfirmasi_spesimen' => 'required|boolean',
            'masalah_peralatan' => 'required|boolean',
            'review_tim' => 'required|boolean',
            'catatan_penting' => 'nullable|string',
        ]);

        // Gabungkan tanggal dan waktu untuk waktu_signout
        $waktuSignout = Carbon::parse($request->tgl_signout . ' ' . $request->jam_signout);

        // Buat record baru
        $signout = new OkCeklistKeselamatanSignout();
        $signout->kd_pasien = $kd_pasien;
        $signout->urut_masuk = $urut_masuk;
        $signout->tgl_masuk = $tgl_masuk;
        $signout->ahli_bedah = $request->ahli_bedah;
        $signout->ahli_anastesi = $request->dokter_anastesi;
        $signout->perawat = $request->perawat;
        $signout->waktu_signout = $waktuSignout;
        $signout->konfirmasi_prosedur = $request->konfirmasi_prosedur;
        $signout->konfirmasi_instrumen = $request->konfirmasi_instrumen;
        $signout->konfirmasi_spesimen = $request->konfirmasi_spesimen;
        $signout->masalah_peralatan = $request->masalah_peralatan;
        $signout->review_tim = $request->review_tim;
        $signout->catatan_penting = $request->catatan_penting;
        $signout->user_create = auth()->user()->id;
        $signout->save();

        return redirect()->route('operasi.pelayanan.ceklist-keselamatan.index', [
            $kd_pasien,
            $tgl_masuk,
            $urut_masuk
        ])->with('success', 'Checklist Sign Out berhasil disimpan!');
    }

    public function editSignout($kd_pasien, $tgl_masuk, $urut_masuk, $id)
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

        $signout = OkCeklistKeselamatanSignout::findOrFail($id);
        $jenisAnastesi = OkJenisAnastesi::all();
        $dokterAnastesi = DokterAnastesi::all();
        $dokter = Dokter::where('status', 1)->get();
        $perawat = Perawat::where('aktif', 1)->get();

        return view('unit-pelayanan.operasi.pelayanan.ceklist-keselamatan.edit-signout', compact(
            'dataMedis',
            'signout',
            'jenisAnastesi',
            'dokterAnastesi',
            'dokter',
            'perawat'
        ));
    }

    public function updateSignout(Request $request, $kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        // Validasi request
        $request->validate([
            'ahli_bedah' => 'required',
            'dokter_anastesi' => 'required',
            'perawat' => 'required',
            'tgl_signout' => 'required|date',
            'jam_signout' => 'required',
            'konfirmasi_prosedur' => 'required|boolean',
            'konfirmasi_instrumen' => 'required|boolean',
            'konfirmasi_spesimen' => 'required|boolean',
            'masalah_peralatan' => 'required|boolean',
            'review_tim' => 'required|boolean',
            'catatan_penting' => 'nullable|string',
        ]);

        // Cari data yang akan diupdate
        $signout = OkCeklistKeselamatanSignout::findOrFail($id);

        // Gabungkan tanggal dan waktu untuk waktu_signout
        $waktuSignout = Carbon::parse($request->tgl_signout . ' ' . $request->jam_signout);

        // Update record
        $signout->ahli_bedah = $request->ahli_bedah;
        $signout->ahli_anastesi = $request->dokter_anastesi;
        $signout->perawat = $request->perawat;
        $signout->waktu_signout = $waktuSignout;
        $signout->konfirmasi_prosedur = $request->konfirmasi_prosedur;
        $signout->konfirmasi_instrumen = $request->konfirmasi_instrumen;
        $signout->konfirmasi_spesimen = $request->konfirmasi_spesimen;
        $signout->masalah_peralatan = $request->masalah_peralatan;
        $signout->review_tim = $request->review_tim;
        $signout->catatan_penting = $request->catatan_penting;
        $signout->user_update = auth()->user()->id;
        $signout->save();

        return redirect()->route('operasi.pelayanan.ceklist-keselamatan.index', [
            $kd_pasien,
            $tgl_masuk,
            $urut_masuk
        ])->with('success', 'Checklist Sign Out berhasil diperbarui!');
    }

    public function destroySignout($kd_pasien, $tgl_masuk, $urut_masuk, $id)
    {
        $signout = OkCeklistKeselamatanSignout::findOrFail($id);
        $signout->delete();

        return redirect()->route('operasi.pelayanan.ceklist-keselamatan.index', [
            $kd_pasien,
            $tgl_masuk,
            $urut_masuk
        ])->with('success', 'Checklist Sign Out berhasil dihapus!');
    }
}
