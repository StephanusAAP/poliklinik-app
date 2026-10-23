<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BuktiBayarDiunggah extends Notification
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
            'title' => 'Bukti Pembayaran Baru',
            'message' => 'Pasien ' . $this->periksa->daftarPoli->pasien->nama . ' telah mengunggah bukti pembayaran dan menunggu verifikasi admin.',
            'url' => route('riwayat-pasien.show', $this->periksa->id)
        ];
    }
}
