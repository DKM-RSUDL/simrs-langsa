<?php

namespace App\Http\Controllers\BerkasDigital;

use App\Http\Controllers\Controller;
use App\Models\SettingBerkasDigital;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SettingBerkasController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read berkas-digital');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SettingBerkasDigital::query();

            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    return '<button id="UpdateBerkas" data-id="' . $row->id . '" class="btn btn-sm btn-warning  m-auto" >
                            <i class="fas fa-edit">
                        </button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('berkas-digital.settings.index');
    }

    public function show($id)
    {
        $data = SettingBerkasDigital::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {

        try {
            DB::beginTransaction();
            $data = SettingBerkasDigital::findOrFail($id);

            $data->update([
                'aktif' => $request->aktif ? '1' : '0',
            ]);

            return back()->withInput()->with('success', 'Data Berhasil Di Update');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
