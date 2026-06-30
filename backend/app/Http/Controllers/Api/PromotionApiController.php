<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Promotion;

class PromotionApiController extends Controller
{
    public function index()
    {
        $promotions = Promotion::active()
            ->current()
            ->orderBy('start_date', 'desc')
            ->get();

        return response()->json(['data' => $promotions]);
    }
}
