<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Article;
use App\Models\Gallery;
use App\Models\LocationCheck;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalBranches' => Branch::count(),
            'totalArticles' => Article::count(),
            'totalGalleries' => Gallery::count(),
            'todayChecks' => LocationCheck::whereDate('created_at', today())->count(),
            'recentChecks' => LocationCheck::with('nearestBranch')
                ->latest()
                ->take(10)
                ->get(),
        ];

        return view('admin.pages.dashboard', $data);
    }
}
