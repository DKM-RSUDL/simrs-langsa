<?php

namespace App\Http\Controllers\BerkasDigital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BerkasDigitalController extends Controller
{
    private $pelArr;
    private $pel;

    public function __construct(Request $request)
    {
        $this->pelArr = ['ri', 'rj']; // 'ri' for Rawat Inap, 'rj' for Rawat Jalan
        $this->pel = in_array($request->get('pel'), $this->pelArr) ? $request->get('pel') : 'ri';
    }

    public function index(Request $request)
    {
        return view('berkas-digital.document.index');
    }
}
