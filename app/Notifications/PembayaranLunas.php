<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PembayaranLunas extends Notification
{
    use Queueable;

    protected $periksa;

    public function __construct($periksa)
    {
        $this->periksa = $periksa;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'Pembayaran Dikonfirmasi',
            'message' => 'Tagihan periksa Anda pada tanggal ' . \Carbon\Carbon::parse($this->periksa->tgl_periksa)->format('d/m/Y') . ' telah diverifikasi (LUNAS).',
            'url' => route('pasien.tagihan.index')
        ];
    }
}
