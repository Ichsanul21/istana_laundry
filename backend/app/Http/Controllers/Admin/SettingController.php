<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');

        return view('admin.pages.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'wa_center' => 'nullable|string|max:20',
            'wa_gatot_subroto' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'company_tagline' => 'nullable|string|max:255',
            'company_address' => 'nullable|string|max:500',
            'company_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255',
            'default_meta_title' => 'nullable|string|max:70',
            'default_meta_description' => 'nullable|string|max:160',
        ]);

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
