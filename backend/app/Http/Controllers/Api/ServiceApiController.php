<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceApiController extends Controller
{
    public function index()
    {
        $services = Service::active()
            ->orderBy('sort_order')
            ->get(['id', 'name', 'slug', 'description', 'price', 'unit', 'icon']);

        return response()->json(['data' => $services]);
    }
}
