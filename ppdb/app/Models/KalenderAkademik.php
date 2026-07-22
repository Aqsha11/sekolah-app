<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KalenderAkademik extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'tipe',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Warna berdasarkan tipe event
     */
    public function getWarnaAttribute(): string
    {
        return match ($this->tipe) {
            'libur' => 'bg-red-100 text-red-700 border-red-300',
            'ujian' => 'bg-amber-100 text-amber-700 border-amber-300',
            'kegiatan' => 'bg-blue-100 text-blue-700 border-blue-300',
            'penting' => 'bg-purple-100 text-purple-700 border-purple-300',
            default => 'bg-gray-100 text-gray-700 border-gray-300',
        };
    }

    /**
     * Icon berdasarkan tipe
     */
    public function getIconAttribute(): string
    {
        return match ($this->tipe) {
            'libur' => 'fa-solid fa-umbrella-beach',
            'ujian' => 'fa-solid fa-pen-fancy',
            'kegiatan' => 'fa-solid fa-calendar-check',
            'penting' => 'fa-solid fa-exclamation-triangle',
            default => 'fa-solid fa-calendar',
        };
    }

    /**
     * Dot color untuk kalender (inline style)
     */
    public function getDotColorAttribute(): string
    {
        return match ($this->tipe) {
            'libur' => '#ef4444',
            'ujian' => '#f59e0b',
            'kegiatan' => '#3b82f6',
            'penting' => '#8b5cf6',
            default => '#6b7280',
        };
    }

    /**
     * Cek apakah event aktif pada tanggal tertentu
     */
    public function isActiveOn($date): bool
    {
        $d = \Carbon\Carbon::parse($date);
        $end = $this->tanggal_selesai ?? $this->tanggal_mulai;

        return $d->between($this->tanggal_mulai, $end) && $this->is_active;
    }
}
