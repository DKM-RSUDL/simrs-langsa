<?php

namespace App\Http\Controllers\BerkasDigital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BerkasDigitalController extends Controller
{
    public function index(Request $request)
    {
        return view('berkas-digital.document.index');
    }
}
