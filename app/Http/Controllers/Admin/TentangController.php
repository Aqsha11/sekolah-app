<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TentangController extends Controller
{
    public function index()
    {
        $setting = Setting::firstOrCreate([]);

        return view('admin.tentang.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'school_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:1024',
        ]);

        $setting = Setting::firstOrCreate([]);

        if ($request->hasFile('logo')) {

            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }

            $setting->logo = $request
                ->file('logo')
                ->store('settings/logo', 'public');
        }

        if ($request->hasFile('favicon')) {

            if ($setting->favicon) {
                Storage::disk('public')->delete($setting->favicon);
            }

            $setting->favicon = $request
                ->file('favicon')
                ->store('settings/favicon', 'public');
        }

        $setting->site_name = $request->site_name;
        $setting->school_name = $request->school_name;
        $setting->tagline = $request->tagline;

        $setting->email = $request->email;
        $setting->phone = $request->phone;
        $setting->whatsapp = $request->whatsapp;

        $setting->address = $request->address;

        $setting->facebook = $request->facebook;
        $setting->instagram = $request->instagram;
        $setting->youtube = $request->youtube;
        $setting->tiktok = $request->tiktok;

        $setting->slider_title = $request->slider_title;
        $setting->slider_subtitle = $request->slider_subtitle;

        $setting->footer_text = $request->footer_text;

        $setting->save();

        return redirect()
            ->route('admin.tentang.index')
            ->with('success', 'Pengaturan website berhasil diperbarui.');
    }
}