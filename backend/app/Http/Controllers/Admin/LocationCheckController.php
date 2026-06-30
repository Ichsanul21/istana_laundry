<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LocationCheck;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LocationCheckController extends Controller
{
    public function index(Request $request)
    {
        $query = LocationCheck::with('nearestBranch')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('whatsapp', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_within_radius', $request->status === 'within');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $checks = $query->paginate(20)->withQueryString();

        return view('admin.pages.location-checks.index', compact('checks'));
    }

    public function show(LocationCheck $locationCheck)
    {
        $locationCheck->load('nearestBranch');

        return view('admin.pages.location-checks.show', compact('locationCheck'));
    }

    public function export(Request $request): StreamedResponse
    {
        $query = LocationCheck::with('nearestBranch')->latest();

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $checks = $query->get();

        return new StreamedResponse(function () use ($checks) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Tanggal', 'Nama', 'WhatsApp', 'Alamat', 'Lat', 'Lng', 'Cabang Terdekat', 'Jarak (km)', 'Dalam Jangkauan']);

            foreach ($checks as $check) {
                fputcsv($handle, [
                    $check->created_at->format('Y-m-d H:i'),
                    $check->name,
                    $check->whatsapp,
                    $check->address,
                    $check->lat,
                    $check->lng,
                    $check->nearestBranch?->name ?? '-',
                    number_format($check->distance_km, 3),
                    $check->is_within_radius ? 'Ya' : 'Tidak',
                ]);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="location-checks-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
}
