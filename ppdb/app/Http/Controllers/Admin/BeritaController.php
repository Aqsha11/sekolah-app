<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class BeritaController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('permission:manage berita', [
        //     'only' => ['create', 'store', 'edit', 'update', 'destroy']
        // ]);
    }

    /**
     * Daftar berita (dengan pencarian)
     */
    public function index(Request $request): View
    {
        $query = Berita::query();

        // Filter pencarian judul
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $berita = $query->latest()->paginate(10);

        return view('admin.berita.index', compact('berita'));
    }

    /**
     * Form tambah berita baru
     */
    public function create(): View
    {
        return view('admin.berita.create');
    }

    /**
     * Simpan berita baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category' => 'nullable',
            'date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload gambar jika ada
        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('berita', $imageName, 'public');
        }

        Berita::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'category' => $request->category,
            'image' => $imageName,
            'published_at' => $request->date ?? now(),
            'is_published' => $request->is_published ?? 0,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan');
    }

    /**
     * Detail berita
     */
    public function show($id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.show', compact('berita'));
    }

    /**
     * Form edit berita
     */
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Update berita
     */
    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $validated = $request->validate([
            'title' => 'string|max:255',
            'content' => 'string',
            'category' => 'nullable',
            'date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload ulang gambar jika ada
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('berita', $filename, 'public');
            $validated['image'] = $filename;
        }

        // Auto-generate slug & set published_at
        $validated['slug'] = Str::slug($request->title);
        $validated['published_at'] = $request->date ?? $berita->published_at;
        $validated['is_published'] = $request->boolean('is_published');

        $berita->update($validated);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui');
    }

    /**
     * Hapus berita (beserta file gambar)
     */
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        // Hapus file gambar dari storage
        if ($berita->image && file_exists(storage_path('app/public/berita/' . $berita->image))) {
            unlink(storage_path('app/public/berita/' . $berita->image));
        }

        $berita->delete();

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus');
    }
}
