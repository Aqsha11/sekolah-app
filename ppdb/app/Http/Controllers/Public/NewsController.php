<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    /**
     * Daftar berita publik (filter: pencarian & kategori)
     */
    public function index(Request $request): View
    {
        $settings = Setting::pluck('value', 'key');

        $query = Berita::where('is_published', true);

        // Pencarian berdasarkan judul/konten
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        // Filter kategori
        if ($request->category) {
            $query->where('category', $request->category);
        }

        $berita = $query->latest()->paginate(6)->withQueryString();
        $categories = Berita::where('is_published', true)->select('category')->distinct()->pluck('category');
        $artikelTerbaru = Berita::where('is_published', true)->latest()->take(5)->get();
        $schoolName = $settings['profil_sekolah'] ?? 'Sekolah';

        return view('public.news', compact('settings', 'berita', 'categories', 'artikelTerbaru', 'schoolName'));
    }

    /**
     * Detail berita + 4 artikel terkait
     */
    public function show(Berita $berita): View
    {
        $settings = Setting::pluck('value', 'key');

        $relatedNews = Berita::where('id', '!=', $berita->id)
            ->where('is_published', true)
            ->latest()
            ->take(4)
            ->get();

        $schoolName = $settings['profil_sekolah'] ?? 'Sekolah';

        return view('public.news_detail', compact('settings', 'berita', 'relatedNews', 'schoolName'));
    }
}
