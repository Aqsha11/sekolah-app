<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Tampilkan daftar pengaturan
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Form edit pengaturan
     */
    public function edit()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.settings.edit', compact('settings'));
    }

    /**
     * Halaman profil publik
     */
    public function tentang()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('public.profil', compact('settings'));
    }

    /**
     * Detail pengaturan
     */
    public function show()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('admin.settings.show', compact('settings'));
    }

    /**
     * Update pengaturan website
     */
    public function update(Request $request)
    {
        $request->validate([
            'profil_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'favicon' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'slider_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $fields = [

            // profil sekolah
            'profil_sekolah',
            'sambutan_kepsek',
            'nama_kepsek',
            'visi',
            'misi',
            'sejarah',

            // kontak
            'email',
            'telepon',
            'alamat',
            'jam_operasional',
            'google_maps',

            // website
            'nama_website',
            'tagline',
            'school_name',

            // hero lama
            'hero_title',
            'hero_description',

            // sosial media
            'social_media',

            // slider
            'slider_title',
            'slider_description',
            'slider_button',
            'slider_link',
        ];

        foreach ($fields as $field) {

            if ($field === 'social_media') {
                continue;
            }

            Setting::updateOrCreate(
                ['key' => $field],
                ['value' => $request->input($field)]
            );
        }
        if ($request->has('social_media')) {

            Setting::updateOrCreate(
                ['key' => 'social_media'],
                [
                    'value' => json_encode(
                        array_values($request->social_media),
                        JSON_UNESCAPED_UNICODE
                    )
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Profil Sekolah
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('profil_image')) {

            $filename = time() . '_profil.' .
                $request->profil_image->extension();

            $request->profil_image->storeAs(
                'settings',
                $filename,
                'public'
            );

            Setting::updateOrCreate(
                ['key' => 'profil_image'],
                ['value' => $filename]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Hero Image
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('hero_image')) {

            $filename = time() . '_hero.' .
                $request->hero_image->extension();

            $request->hero_image->storeAs(
                'settings',
                $filename,
                'public'
            );

            Setting::updateOrCreate(
                ['key' => 'hero_image'],
                ['value' => $filename]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Logo Website
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('logo')) {

            $filename = time() . '_logo.' .
                $request->logo->extension();

            $request->logo->storeAs(
                'settings',
                $filename,
                'public'
            );

            Setting::updateOrCreate(
                ['key' => 'logo'],
                ['value' => $filename]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Favicon
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('favicon')) {

            $filename = time() . '_favicon.' .
                $request->favicon->extension();

            $request->favicon->storeAs(
                'settings',
                $filename,
                'public'
            );

            Setting::updateOrCreate(
                ['key' => 'favicon'],
                ['value' => $filename]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Slider Image
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('slider_image')) {

            $filename = time() . '_slider.' .
                $request->slider_image->extension();

            $request->slider_image->storeAs(
                'settings',
                $filename,
                'public'
            );

            Setting::updateOrCreate(
                ['key' => 'slider_image'],
                ['value' => $filename]
            );
        }

        return redirect()
            ->route('admin.settings.index')
            ->with(
                'success',
                'Pengaturan website berhasil diperbarui.'
            );
    }
}
