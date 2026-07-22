<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class KontakController extends Controller
{
    /**
     * Daftar pesan masuk dari pengunjung website
     */
    public function index(Request $request): View
    {
        $query = Kontak::query();

        // Filter pencarian (nama/email)
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter status (unread/read/replied)
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $kontak = $query->latest()->paginate(20);

        $statuses = [
            'unread' => 'Belum Dibaca',
            'read' => 'Sudah Dibaca',
            'replied' => 'Sudah Dibalas'
        ];

        return view('admin.kontak.index', compact('kontak', 'statuses'));
    }

    /**
     * Tandai pesan sebagai sudah dibaca
     */
    public function markAsRead(Kontak $kontak)
    {
        $updated = $kontak->update([
            'status' => 'read'
        ]);

        if (!$updated) {
            return redirect()->back()->with('error', 'Gagal update status');
        }

        return redirect()
            ->route('admin.kontak.show', $kontak->id)
            ->with('success', 'Pesan sudah dibaca');
    }

    /**
     * Detail pesan (otomatis tandai read jika masih unread)
     */
    public function show(Kontak $kontak): View
    {
        if ($kontak->status === 'unread') {
            $kontak->update(['status' => 'read']);
        }

        return view('admin.kontak.show', compact('kontak'));
    }

    /**
     * Kirim balasan pesan
     */
    public function reply(Request $request, Kontak $kontak): RedirectResponse
    {
        $validated = $request->validate([
            'reply_message' => 'required|string|min:10',
        ]);

        $kontak->update([
            'reply_message' => $validated['reply_message'],
            'status' => 'replied',
            'replied_by' => auth()->id(),
            'replied_at' => now(),
        ]);

        return redirect()
            ->route('admin.kontak.index')
            ->with('success', 'Balasan berhasil dikirim');
    }

    /**
     * Hapus pesan
     */
    public function destroy(Kontak $kontak): RedirectResponse
    {
        $kontak->delete();

        return redirect()
            ->route('admin.kontak.index')
            ->with('success', 'Pesan berhasil dihapus');
    }
}
