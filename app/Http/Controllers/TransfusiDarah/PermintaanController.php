<?php

namespace App\Http\Controllers\TransfusiDarah;

use App\Http\Controllers\Controller;
use App\Models\BdrsPermintaanDarah;
use Illuminate\Http\Request;

class PermintaanController extends Controller
{
    public function index()
    {
        $orders = BdrsPermintaanDarah::all();

        return view('transfusi-darah.permintaan.index', compact('orders'));
    }
}