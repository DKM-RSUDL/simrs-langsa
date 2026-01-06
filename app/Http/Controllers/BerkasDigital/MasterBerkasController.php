<?php

namespace App\Http\Controllers\BerkasDigital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterBerkasDigital;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // <--- 1. WAJIB IMPORT INI

class MasterBerkasController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read berkas-digital');
    }

    public function index(Request $request)
    {
        try {
            $keyword = $request->get('keyword');
            $query = MasterBerkasDigital::query();

            if (!empty($keyword)) {
                $query->where('nama_berkas', 'LIKE', "%$keyword%")
                    ->orWhere('id', 'LIKE', "%$keyword%");
            }

            $berkas = $query->get();
            return view('berkas-digital.master.index', compact('berkas'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memuat data: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'nama_berkas' => 'required|unique:RME_MR_BERKAS_DIGITAL,nama_berkas',
            ], [
                'nama_berkas.unique' => 'Nama berkas ini sudah terdaftar di sistem.'
            ]);

            MasterBerkasDigital::create([
                'nama_berkas' => $request->nama_berkas,
                // 2. TAMBAHKAN INI (Generate Slug otomatis pakai Library)
                'slug'        => Str::slug($request->nama_berkas, '_'),
                'user_create' => Auth::user()->kd_karyawan,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Master Berkas berhasil ditambah!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'nama_berkas' => 'required|unique:RME_MR_BERKAS_DIGITAL,nama_berkas,' . $id,
            ]);

            $berkas = MasterBerkasDigital::findOrFail($id);

            $berkas->update([
                'nama_berkas' => $request->nama_berkas,
                // 3. TAMBAHKAN JUGA DISINI (Agar waktu edit, slug ikut berubah)
                'slug'        => Str::slug($request->nama_berkas, '_'),
                'user_update' => Auth::user()->kd_karyawan,
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Master Berkas berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $berkas = MasterBerkasDigital::findOrFail($id);
            $berkas->delete();

            DB::commit();

            return redirect()->back()->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $berkas = MasterBerkasDigital::findOrFail($id);

        return response()->json([
            'status' => true,
            'data'   => $berkas
        ]);
    }
}
