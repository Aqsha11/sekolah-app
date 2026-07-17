<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KalenderAkademik;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KalenderAkademikController extends Controller
{
    /**
     * Tampilan kalender (grid bulanan)
     */
    public function index(Request $request): View
    {
        $bulan = $request->filled('bulan')
            ? \Carbon\Carbon::parse($request->bulan)->startOfMonth()
            : \Carbon\Carbon::now()->startOfMonth();

        $events = KalenderAkademik::where('is_active', true)
            ->where(function ($q) use ($bulan) {
                $q->whereBetween('tanggal_mulai', [$bulan->copy()->startOfMonth(), $bulan->copy()->endOfMonth()])
                    ->orWhereBetween('tanggal_selesai', [$bulan->copy()->startOfMonth(), $bulan->copy()->endOfMonth()])
                    ->orWhere(function ($q2) use ($bulan) {
                        $q2->where('tanggal_mulai', '<=', $bulan->copy()->startOfMonth())
                            ->where('tanggal_selesai', '>=', $bulan->copy()->endOfMonth());
                    });
            })
            ->orderBy('tanggal_mulai')
            ->get();

        $allEvents = KalenderAkademik::orderBy('tanggal_mulai', 'desc')->paginate(15);

        return view('admin.kalender.index', compact('events', 'allEvents', 'bulan'));
    }

    /**
     * Form tambah event
     */
    public function create(): View
    {
        return view('admin.kalender.create');
    }

    /**
     * Simpan event baru
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'tipe' => 'required|in:libur,ujian,kegiatan,penting',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        KalenderAkademik::create($validated);

        return redirect()->route('admin.kalender.index')
            ->with('success', 'Event kalender berhasil ditambahkan');
    }

    /**
     * Form edit event
     */
    public function edit(KalenderAkademik $kalender): View
    {
        return view('admin.kalender.edit', compact('kalender'));
    }

    /**
     * Update event
     */
    public function update(Request $request, KalenderAkademik $kalender): RedirectResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'tipe' => 'required|in:libur,ujian,kegiatan,penting',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $kalender->update($validated);

        return redirect()->route('admin.kalender.index')
            ->with('success', 'Event kalender berhasil diperbarui');
    }

    /**
     * Hapus event
     */
    public function destroy(KalenderAkademik $kalender): RedirectResponse
    {
        $kalender->delete();

        return redirect()->route('admin.kalender.index')
            ->with('success', 'Event kalender berhasil dihapus');
    }
}
