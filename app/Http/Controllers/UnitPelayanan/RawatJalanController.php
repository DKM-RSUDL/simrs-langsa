<?php

namespace App\Http\Controllers\UnitPelayanan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RawatJalanController extends Controller
{
    // public function __construct()
    // {
    //     // Menggunakan middleware 'permission' dari Spatie Laravel-Permission
    //     $this->middleware('permission:rawat-jalan.index')->only('index');
    //     $this->middleware('permission:rawat-jalan.create')->only(['create', 'store']);
    //     $this->middleware('permission:rawat-jalan.edit')->only(['edit', 'update']);
    //     $this->middleware('permission:rawat-jalan.destroy')->only('destroy');
    // }

    public function index()
    {
        return view('unit-pelayanan.rawat-jalan.index');
    }
}
