<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();

        return view('admin.pages.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.pages.testimonials.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_title' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'body' => 'required|string|max:1000',
            'avatar' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        Testimonial::create($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.pages.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_title' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'body' => 'required|string|max:1000',
            'avatar' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('testimonials', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $testimonial->update($validated);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil dihapus.');
    }
}
