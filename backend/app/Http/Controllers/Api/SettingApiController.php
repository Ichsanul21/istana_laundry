<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class SettingApiController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');

        return response()->json(['data' => $settings]);
    }
}
