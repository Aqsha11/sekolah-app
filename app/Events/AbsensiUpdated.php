<?php

namespace App\Events;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AbsensiUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Siswa $siswa,
        public Absensi $absensi,
        public string $action,
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('siswa.' . $this->siswa->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'absensi.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'siswa_id' => $this->siswa->id,
            'nama' => $this->siswa->nama,
            'kelas' => $this->siswa->kelas,
            'action' => $this->action,
            'status' => $this->absensi->status,
            'check_in' => $this->absensi->check_in?->format('H:i:s'),
            'check_out' => $this->absensi->check_out?->format('H:i:s'),
            'tanggal' => $this->absensi->tanggal->toDateString(),
        ];
    }
}
