<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;

class TestimonialApiController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::active()
            ->orderBy('sort_order')
            ->get(['id', 'customer_name', 'customer_title', 'rating', 'body', 'avatar']);

        return response()->json(['data' => $testimonials]);
    }
}
