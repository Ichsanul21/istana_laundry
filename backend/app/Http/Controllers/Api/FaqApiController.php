<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;

class FaqApiController extends Controller
{
    public function index()
    {
        $faqs = Faq::active()
            ->orderBy('sort_order')
            ->get(['id', 'question', 'answer', 'category']);

        return response()->json(['data' => $faqs]);
    }
}
