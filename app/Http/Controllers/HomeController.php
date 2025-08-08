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

        // Data untuk grafik kunjungan bulanan tahun 2025
        $monthlyVisits = $this->getMonthlyVisitsData();
        $chartLabels = $monthlyVisits['labels'];
        $chartData = $monthlyVisits['data'];

        // Prepare data for unit counts (existing functionality)
        $unitCounts = $visits->groupBy('unit.bagian.bagian')->map->count()->toArray();

        return view('home', compact('visits', 'chartLabels', 'chartData', 'today', 'unitCounts'));
    }

    /**
     * Get monthly visits data for 2025
     */
    private function getMonthlyVisitsData()
    {
        $year = 2025;
        $monthNames = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ];

        $monthlyData = [];

        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = Carbon::create($year, $month, 1)->endOfMonth();

            // Count visits for this month
            $count = Kunjungan::whereBetween('tgl_masuk', [$startDate, $endDate])
                ->count();

            $monthlyData[] = $count;
        }

        return [
            'labels' => $monthNames,
            'data' => $monthlyData
        ];
    }
}