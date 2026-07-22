<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Daftar banner (diurutkan berdasarkan order)
     */
    public function index(): View
    {
        $banners = Banner::orderBy('order')->paginate(10);
        return view('admin.banner.index', compact('banners'));
    }

    /**
     * Form tambah banner
     */
    public function create(): View
    {
        return view('admin.banner.create');
    }

    /**
     * Simpan banner baru
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $path = $request->file('image')->store('banners', 'public');

        Banner::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'image' => $path,
            'link' => $request->link,
            'order' => $request->order ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil ditambahkan');
    }

    /**
     * Form edit banner
     */
    public function edit(Banner $banner): View
    {
        return view('admin.banner.edit', compact('banner'));
    }

    /**
     * Update data banner
     */
    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $data = [
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'link' => $request->link,
            'order' => $request->order ?? 0,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil diperbarui');
    }

    /**
     * Hapus banner (beserta file gambar)
     */
    public function destroy(Banner $banner): RedirectResponse
    {
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('admin.banner.index')->with('success', 'Banner berhasil dihapus');
    }
}
