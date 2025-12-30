<?php

namespace App\Http\Controllers\BerkasDigital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterBerkasDigital; // Nama model baru
use Illuminate\Support\Str;
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

        // Fitur Pencarian Berfungsi
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_berkas', 'LIKE', "%$keyword%")
                    ->orWhere('id', 'LIKE', "%$keyword%");
            });
        }

        $berkas = $query->get();
        return view('berkas-digital.master.index', compact('berkas'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama_berkas' => 'required']);

        MasterBerkasDigital::create([
            'nama_berkas' => $request->nama_berkas,
            'slug'        => Str::slug($request->nama_berkas, '_'), // Slug otomatis
            'user_create' => Auth::user()->name,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambah!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama_berkas' => 'required']);

        $berkas = MasterBerkasDigital::findOrFail($id);
        $berkas->update([
            'nama_berkas' => $request->nama_berkas,
            'slug'        => Str::slug($request->nama_berkas, '_'),
            'user_update' => Auth::user()->name,
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        MasterBerkasDigital::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
