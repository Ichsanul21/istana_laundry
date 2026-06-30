<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::orderBy('start_date', 'desc')->get();

        return view('admin.pages.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.pages.promotions.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:promotions,slug',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('promotions', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        Promotion::create($validated);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promo berhasil ditambahkan.');
    }

    public function edit(Promotion $promotion)
    {
        return view('admin.pages.promotions.form', compact('promotion'));
    }

    public function update(Request $request, Promotion $promotion)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:promotions,slug,' . $promotion->id,
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
            'discount_type' => 'required|in:percent,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('promotions', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $promotion->update($validated);

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return redirect()->route('admin.promotions.index')
            ->with('success', 'Promo berhasil dihapus.');
    }
}
