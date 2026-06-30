<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::orderBy('sort_order')->get();

        return view('admin.pages.branches.index', compact('branches'));
    }

    public function create()
    {
        return view('admin.pages.branches.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:workshop,cabang',
            'address' => 'required|string',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'radius_km' => 'required|numeric|min:0.5|max:10',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
            'open_hours' => 'nullable|string|max:255',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Branch::create($validated);

        return redirect()->route('admin.branches.index')
            ->with('success', 'Cabang berhasil ditambahkan.');
    }

    public function edit(Branch $branch)
    {
        return view('admin.pages.branches.form', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:workshop,cabang',
            'address' => 'required|string',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'radius_km' => 'required|numeric|min:0.5|max:10',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
            'open_hours' => 'nullable|string|max:255',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $branch->update($validated);

        return redirect()->route('admin.branches.index')
            ->with('success', 'Cabang berhasil diperbarui.');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()->route('admin.branches.index')
            ->with('success', 'Cabang berhasil dihapus.');
    }
}
