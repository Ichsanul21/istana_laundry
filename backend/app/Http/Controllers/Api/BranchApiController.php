<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;

class BranchApiController extends Controller
{
    public function index()
    {
        $branches = Branch::active()->orderBy('sort_order')->get([
            'id', 'name', 'type', 'address', 'lat', 'lng', 'radius_km', 'phone', 'open_hours',
        ]);

        return response()->json(['data' => $branches]);
    }
}
