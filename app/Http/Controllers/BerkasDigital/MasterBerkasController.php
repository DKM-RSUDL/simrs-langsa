<?php

namespace App\Http\Controllers\BerkasDigital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterBerkasDigital;
use Illuminate\Support\Facades\Auth;

class MasterBerkasController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read berkas-digital');
    }

    public function index(Request $request)
    {
        $keyword = $request->get('keyword');
        $query = MasterBerkasDigital::query();

        if (!empty($keyword)) {
            $query->where('nama_berkas', 'LIKE', "%$keyword%")
                ->orWhere('id', 'LIKE', "%$keyword%");
        }

        $berkas = $query->get();
        return view('berkas-digital.master.index', compact('berkas'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_berkas' => 'required|unique:RME_MR_BERKAS_DIGITAL,nama_berkas',
            ], [
                'nama_berkas.unique' => 'Nama berkas ini sudah terdaftar di sistem.'
            ]);

            MasterBerkasDigital::create([
                'nama_berkas' => $request->nama_berkas,
                'user_create' => Auth::user()->name,
            ]);

            return redirect()->back()->with('success', 'Master Berkas berhasil ditambah!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi unik kecuali untuk ID yang sedang diedit
        $request->validate([
            'nama_berkas' => 'required|unique:RME_MR_BERKAS_DIGITAL,nama_berkas,' . $id,
        ]);

        $berkas = MasterBerkasDigital::findOrFail($id);

        // Update nama_berkas, slug akan ter-update otomatis oleh library
        $berkas->update([
            'nama_berkas' => $request->nama_berkas,
            'user_update' => Auth::user()->name,
        ]);

        return redirect()->back()->with('success', 'Master Berkas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        MasterBerkasDigital::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
