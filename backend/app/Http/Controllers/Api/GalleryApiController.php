<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;

class GalleryApiController extends Controller
{
    public function index()
    {
        $galleries = Gallery::where('is_active', true)
            ->with('images')
            ->orderBy('sort_order')
            ->get();

        return response()->json(['data' => $galleries]);
    }
}
