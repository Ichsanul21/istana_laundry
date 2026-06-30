<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\LocationCheck;
use App\Services\HaversineService;
use Illuminate\Http\Request;

class LocationCheckApiController extends Controller
{
    public function check(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'address' => 'required|string',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'email' => 'nullable|email|max:255',
        ]);

        $branches = Branch::active()->get();
        $nearest = null;
        $nearestDistance = PHP_FLOAT_MAX;

        foreach ($branches as $branch) {
            $distance = HaversineService::distance(
                $validated['lat'], $validated['lng'],
                $branch->lat, $branch->lng
            );

            if ($distance < $nearestDistance) {
                $nearest = $branch;
                $nearestDistance = $distance;
            }
        }

        $isWithinRadius = $nearest && $nearestDistance <= $nearest->radius_km;

        $locationCheck = LocationCheck::create([
            'name' => $validated['name'],
            'whatsapp' => $validated['whatsapp'],
            'address' => $validated['address'],
            'lat' => $validated['lat'],
            'lng' => $validated['lng'],
            'email' => $validated['email'] ?? null,
            'nearest_branch_id' => $nearest?->id,
            'distance_km' => round($nearestDistance, 3),
            'is_within_radius' => $isWithinRadius,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'is_within_radius' => $isWithinRadius,
                'distance_km' => round($nearestDistance, 3),
                'nearest_branch' => $nearest ? [
                    'id' => $nearest->id,
                    'name' => $nearest->name,
                    'address' => $nearest->address,
                    'phone' => $nearest->phone,
                    'radius_km' => $nearest->radius_km,
                ] : null,
            ],
        ]);
    }
}
