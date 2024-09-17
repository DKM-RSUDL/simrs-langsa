<?php

namespace App\Http\Controllers;

use App\Models\TestModel;
use Illuminate\Http\Request;

class TestModelController extends Controller
{
    public function index()
    {
        $dataRegistrPasient = TestModel::all();

        return response()->json([
            'dataRegistrPasient' => $dataRegistrPasient
        ]);
    }
}
