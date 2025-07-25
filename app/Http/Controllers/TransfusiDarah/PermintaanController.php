<?php

namespace App\Http\Controllers\TransfusiDarah;

use App\Http\Controllers\Controller;
use App\Models\BdrsPermintaanDarah;
use App\Models\BdrsPermintaanDarahDetail;
use App\Models\GolonganDarah;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PermintaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:read transfusi-darah/permintaan');
    }

    public function index()
    {
        $units = Unit::whereIn('kd_bagian', [1, 2, 3])->where('aktif', 1)->get();
        return view('transfusi-darah.permintaan.index', compact('units'));
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $orders = BdrsPermintaanDarah::with(['unit', 'dokter', 'pasien']);

            if ($request->kd_unit) $orders->where('kd_unit', $request->kd_unit);
            if (is_numeric($request->status)) $orders->where('status', $request->status);
            if ($request->tgl_awal) $orders->whereDate('tgl_pengiriman', '>=', $request->tgl_awal);
            if ($request->tgl_akhir) $orders->whereDate('tgl_pengiriman', '<=', $request->tgl_akhir);

            $orders->get();

            return DataTables::of($orders)
                ->addIndexColumn()
                ->addColumn('tgl_order', fn($row) => date('d M Y', strtotime($row->tgl_pengiriman)) ?: '-')
                ->addColumn('statuslabel', function ($row) {
                    $statusLabel = '-';
                    $bgLabel = 'secondary';

                    if ($row->status == 0) {
                        $statusLabel = 'Diorder';
                        $bgLabel = 'danger';
                    }
                    if ($row->status == 1) {
                        $statusLabel = 'Diproses';
                        $bgLabel = 'warning';
                    }
                    if ($row->status == 2) {
                        $statusLabel = 'Diserahkan';
                        $bgLabel = 'success';
                    }

                    return "<span class='badge bg-$bgLabel'>$statusLabel</span>";
                })
                ->addColumn('action', function ($row) {
                    $action = '-';
                    $btnBg = 'btn-success';
                    $btnIcon = '<i class="fa-solid fa-eye"></i>';

                    $showUrl = route('transfusi-darah.permintaan.show', [encrypt($row->id)]);

                    if ($row->status == 0) {
                        $btnBg = 'btn-danger';
                        $btnIcon = '<i class="fa-solid fa-arrows-rotate"></i>';
                    }

                    if ($row->status == 1) {
                        $btnBg = 'btn-warning';
                        $btnIcon = '<i class="fa-solid fa-handshake"></i>';
                    }

                    $action .= "<a href='$showUrl' class='btn btn-sm $btnBg'>$btnIcon</a>";

                    return $action;
                })
                ->order(function ($q) {
                    $q->orderBy('id', 'desc');
                })
                ->rawColumns(['tgl_order', 'action', 'statuslabel'])
                ->make(true);
        }
    }

    public function show($idEncrypt)
    {
        $id = decrypt($idEncrypt);
        $order = BdrsPermintaanDarah::find($id);
        $golDarah = GolonganDarah::all();

        return view('transfusi-darah.permintaan.show', compact('order', 'golDarah'));
    }

    public function prosesOrder($idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($idEncrypt);
            $order = BdrsPermintaanDarah::find($id);
            if (empty($order)) throw new Exception('Permintaan darah tidak ditemukan !');

            // update order
            $order->petugas_penerima_sampel = $request->petugas_penerima_sampel;
            $order->user_penerima_sampel = Auth::id();
            $order->tgl_terima_sampel = $request->tgl_terima_sampel;
            $order->jam_terima_sampel = $request->jam_terima_sampel;
            $order->abo = $request->abo;
            $order->kd_rhesus = $request->kd_rhesus;
            $order->status = 1;
            $order->save();

            DB::commit();
            return back()->with('success', 'Order berhasil di terima dan di proses !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function updatePemeriksaan($idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($idEncrypt);
            $order = BdrsPermintaanDarah::find($id);
            if (empty($order)) throw new Exception('Permintaan darah tidak ditemukan !');

            $order->petugas_pemeriksa = $request->petugas_pemeriksa;
            $order->tgl_periksa = $request->tgl_periksa;
            $order->jam_periksa = $request->jam_periksa;
            $order->hasil_pemeriksaan = $request->hasil_pemeriksaan;
            $order->user_pemeriksa = Auth::id();
            $order->save();

            DB::commit();
            return back()->with('success', 'Darah berhasil diperiksa !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function handOver($idEncrypt, Request $request)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($idEncrypt);
            $order = BdrsPermintaanDarah::find($id);
            if (empty($order)) throw new Exception('Permintaan darah tidak ditemukan !');

            // store order detail
            $data = [
                'kd_pasien'                 => $order->kd_pasien,
                'kd_unit'                   => $order->kd_unit,
                'tgl_masuk'                 => $order->tgl_masuk,
                'urut_masuk'                => $order->urut_masuk,
                'no_kantong'                => $request->no_kantong,
                'kd_golda'                  => $request->kd_golda,
                'kd_rhesus'                 => $order->kd_rhesus,
                'tgl_pengambilan'           => $request->tgl_pengambilan,
                'vol_kantong'               => $request->vol_kantong,
                'nama_petugas_pengambilan'  => $request->petugas_ambil,
                'nama_petugas_penerima'     => $order->petugas_penerima_sampel,
                'nama_petugas_pemberian'    => $order->petugas_pemeriksa,
                'id_order'                  => $order->id,
                'jenis_darah'               => $request->jenis_darah,
                'user_create'               => Auth::id()
            ];

            // update data order
            DB::table('bdrs_permintaan_darah_detail')->insert($data);

            DB::commit();
            return to_route('transfusi-darah.permintaan.index')->with('success', 'Darah berhasil diserahkan !');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function completeProcess($idEncrypt)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($idEncrypt);
            $order = BdrsPermintaanDarah::find($id);
            if (empty($order)) throw new Exception('Permintaan darah tidak ditemukan !');

            $order->status = 2;
            $order->user_selesaikan = Auth::id();
            $order->save();

            DB::commit();
            return to_route('transfusi-darah.permintaan.index')->with('success', 'Order diselesaikan');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteDarah($idEncrypt)
    {
        DB::beginTransaction();

        try {
            $id = decrypt($idEncrypt);
            $darah = BdrsPermintaanDarahDetail::find($id);
            if (empty($darah)) throw new Exception('Darah tidak ditemukan !');
            $noKantong = $darah->no_kantong;

            // delete
            BdrsPermintaanDarahDetail::where('id', $id)->delete();

            DB::commit();
            return back()->with('success', "Darah $noKantong dihapus !");
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
