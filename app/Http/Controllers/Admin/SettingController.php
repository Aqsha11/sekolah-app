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
        $settings = Setting::pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Form edit pengaturan
     */
    public function edit()
    {
        $settings = Setting::pluck('value', 'key');
        return view('admin.settings.edit', compact('settings'));
    }

    /**
     * Halaman profil publik (tentang sekolah)
     */
    public function tentang()
    {
        $settings = Setting::pluck('value', 'key');
        return view('public.profil', compact('settings'));
    }

    /**
     * Detail pengaturan
     */
    public function show()
    {
        $settings = Setting::pluck('value', 'key');
        return view('admin.settings.show', compact('settings'));
    }

    /**
     * Simpan perubahan pengaturan (teks dan gambar)
     */
    public function update(Request $request)
    {
        $request->validate([
            'profil_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'hero_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Simpan semua pengaturan teks
        $data = $request->only([
            'profil_sekolah',
            'visi',
            'misi',
            'sejarah',
            'email',
            'telepon',
            'alamat',
            'jam_operasional',
            'google_maps',
            'sambutan_kepsek',
            'nama_kepsek',
            'hero_title',
            'hero_description',
            'school_name',
        ]);

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Upload gambar profil jika ada
        if ($request->hasFile('profil_image')) {
            $file = $request->file('profil_image');
            $filename = time() . '_profil.' . $file->getClientOriginalExtension();
            $file->storeAs('settings', $filename, 'public');
            Setting::updateOrCreate(
                ['key' => 'profil_image'],
                ['value' => $filename]
            );
        }

        // Upload gambar hero jika ada
        if ($request->hasFile('hero_image')) {
            $file = $request->file('hero_image');
            $filename = time() . '_hero.' . $file->getClientOriginalExtension();
            $file->storeAs('settings', $filename, 'public');
            Setting::updateOrCreate(
                ['key' => 'hero_image'],
                ['value' => $filename]
            );
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings berhasil diupdate');
    }
}
