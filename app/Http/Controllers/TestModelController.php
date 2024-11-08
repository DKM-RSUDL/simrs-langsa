<?php

namespace App\Http\Controllers;

use App\Models\TestModel;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestModelController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $data = TestModel::all();

            return response()->json([
                'success' => true,
                'message' => 'Data retrieved successfully',
                'data' => $data
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
