<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarpetInspection;
use Illuminate\Http\Request;

class CarpetInspectionController extends Controller
{
    public function index(Request $request)
    {
        $query = CarpetInspection::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('whatsapp', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('condition')) {
            $query->where('overall_condition', $request->condition);
        }

        $inspections = $query->paginate(20)->withQueryString();

        return view('admin.pages.carpet-inspections.index', compact('inspections'));
    }

    public function show(CarpetInspection $carpetInspection)
    {
        return view('admin.pages.carpet-inspections.show', ['inspection' => $carpetInspection]);
    }
}
