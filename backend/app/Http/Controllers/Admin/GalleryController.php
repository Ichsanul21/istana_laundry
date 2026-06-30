<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::withCount('images')->orderBy('sort_order')->get();

        return view('admin.pages.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.pages.galleries.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:galleries,slug',
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $gallery = Gallery::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('galleries', 'public');
                $gallery->images()->create([
                    'image_path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        $gallery->load('images');

        return view('admin.pages.galleries.form', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:galleries,slug,' . $gallery->id,
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $gallery->update($validated);

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();

        return redirect()->route('admin.galleries.index')
            ->with('success', 'Galeri berhasil dihapus.');
    }

    public function uploadImage(Request $request, Gallery $gallery)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('galleries', 'public');
        $maxOrder = $gallery->images()->max('sort_order') ?? -1;

        $image = $gallery->images()->create([
            'image_path' => $path,
            'sort_order' => $maxOrder + 1,
        ]);

        return response()->json([
            'success' => true,
            'image' => [
                'id' => $image->id,
                'image_path' => $image->image_path,
                'caption' => $image->caption,
                'alt_text' => $image->alt_text,
                'sort_order' => $image->sort_order,
            ],
        ]);
    }

    public function deleteImage(GalleryImage $image)
    {
        $image->delete();

        return response()->json(['success' => true]);
    }

    public function reorderImages(Request $request, Gallery $gallery)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:gallery_images,id',
        ]);

        foreach ($request->order as $index => $imageId) {
            GalleryImage::where('id', $imageId)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
