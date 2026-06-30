<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoSetting;
use Illuminate\Http\Request;

class SeoSettingController extends Controller
{
    public function index()
    {
        $seoSettings = SeoSetting::orderBy('page')->get();

        return view('admin.pages.seo-settings.index', compact('seoSettings'));
    }

    public function edit(SeoSetting $seoSetting)
    {
        return view('admin.pages.seo-settings.form', compact('seoSetting'));
    }

    public function update(Request $request, SeoSetting $seoSetting)
    {
        $validated = $request->validate([
            'meta_title' => 'nullable|string|max:70',
            'meta_description' => 'nullable|string|max:160',
            'og_title' => 'nullable|string|max:70',
            'og_description' => 'nullable|string|max:160',
            'og_image' => 'nullable|string|max:255',
            'schema_type' => 'nullable|string|max:100',
        ]);

        $seoSetting->update($validated);

        return redirect()->route('admin.seo-settings.index')
            ->with('success', 'SEO Setting berhasil diperbarui.');
    }
}
