<?php

namespace App\Http\Controllers\BerkasDigital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BerkasDigital;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class MasterBerkasController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read berkas-digital'); // [cite: 1390]
    }

    public function index(Request $request)
    {
        // Mengambil kata kunci dari input pencarian
        $keyword = $request->get('keyword');

        // Query dasar ke tabel RME_MR_BERKAS_DIGITAL
        $query = BerkasDigital::query();

        // Jika ada keyword, saring berdasarkan nama_berkas atau id
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_berkas', 'LIKE', "%$keyword%")
                    ->orWhere('id', 'LIKE', "%$keyword%");
            });
        }

        // Mengambil data hasil query
        $berkas = $query->get();

        return view('berkas-digital.master.index', compact('berkas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_berkas' => 'required',
        ]);

        BerkasDigital::create([
            'nama_berkas' => $request->nama_berkas,
            'slug'        => Str::slug($request->nama_berkas, '_'), // Generate slug otomatis
            'user_create' => Auth::user()->name,
        ]);

        return redirect()->back()->with('success', 'Master Berkas berhasil ditambah!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_berkas' => 'required',
        ]);

        $berkas = BerkasDigital::findOrFail($id);
        $berkas->update([
            'nama_berkas' => $request->nama_berkas,
            'slug'        => Str::slug($request->nama_berkas, '_'),
            'user_update' => Auth::user()->name,
        ]);

        return redirect()->back()->with('success', 'Master Berkas berhasil diperbarui!');
    }

    public function destroy($id)
    {
        BerkasDigital::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Master Berkas berhasil dihapus!');
    }
}
