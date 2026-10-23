<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AntrianDiupdate implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $idJadwal;
    public $nomorSekarang;

    public function __construct($idJadwal, $nomorSekarang)
    {
        $this->idJadwal = $idJadwal;
        $this->nomorSekarang = $nomorSekarang;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('antrian.' . $this->idJadwal),
        ];
    }

    public function broadcastAs(): string
    {
        return 'AntrianDiupdate';
    }
}
