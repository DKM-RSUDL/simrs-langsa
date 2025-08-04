<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Initial data: today's visits
        $today = Carbon::today()->toDateString();
        $threeDaysAgo = Carbon::parse($today)->subDays(3)->toDateString();
        $visits = Kunjungan::with(['pasien', 'unit', 'dokter', 'caraPenerimaan'])
            ->whereDate('tgl_masuk', $today)
            ->get();

        if ($visits->isEmpty()) {
            $visits = Kunjungan::with(['pasien', 'unit', 'dokter', 'caraPenerimaan'])
                ->whereDate('tgl_masuk', '>=', $threeDaysAgo)
                ->orderBy('tgl_masuk', 'desc')
                ->take(100)
                ->get();
        }

        // Data untuk grafik dengan fungsi yang sudah ada dan yang baru
        $dataChart = [
            'Rawat Inap' => countAktivePatientAllRanap(),
            'Gawat Darurat' => countActivePatientAllIGD(),
        ];

        // Prepare data for chart (visits per unit)
        $unitCounts = $visits->groupBy('unit.bagian.bagian')->map->count()->toArray();
        $chartLabels = array_keys($dataChart);
        $chartData = array_values($dataChart);

        return view('home', compact('visits', 'chartLabels', 'chartData', 'today', 'unitCounts'));
    }
}