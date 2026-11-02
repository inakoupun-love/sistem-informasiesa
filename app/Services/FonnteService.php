<?php

namespace App\Services;

use App\Models\Bansos;
use App\Models\Pengajuan;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    public function sendPengajuanNotification(Pengajuan $pengajuan, string $event): bool
    {
        $phone = $this->normalizePhone($pengajuan->user?->phone);
        $token = config('services.fonnte.token');

        if (!$phone || !$token) {
            Log::warning('Notifikasi WhatsApp Fonnte tidak dikirim karena nomor telepon atau token belum tersedia.', [
                'pengajuan_id' => $pengajuan->id,
                'has_phone' => (bool) $phone,
                'has_token' => (bool) $token,
            ]);
            return false;
        }

        $userName = $pengajuan->user?->name;
        $namaSurat = $pengajuan->jenisSurat?->nama_surat;
        $keterangan = $pengajuan->keterangan;

        $message = match ($event) {
            'approved' => "Halo {$userName}, pengajuan surat {$namaSurat} Anda telah disetujui. Silakan menunggu proses pencetakan surat.",
            'printed' => "Halo {$userName}, surat {$namaSurat} Anda telah dicetak dan dapat diambil di Kantor Desa Kalinaun.",
            'rejected' => "Halo {$userName}, pengajuan surat {$namaSurat} Anda telah ditolak." . ($keterangan ? " Keterangan: {$keterangan}." : ''),
            default => null,
        };

        if (!$message) {
            return false;
        }

        return $this->send($phone, $token, $message, "pengajuan {$pengajuan->id} ({$event})");
    }

    public function sendBansosNotification(Bansos $bansos, string $event): bool
    {
        $phone = $this->normalizePhone($bansos->user?->phone);
        $token = config('services.fonnte.token');

        if (!$phone || !$token) {
            Log::warning('Notifikasi WhatsApp Fonnte tidak dikirim karena nomor telepon atau token belum tersedia.', [
                'bansos_id' => $bansos->id,
                'has_phone' => (bool) $phone,
                'has_token' => (bool) $token,
            ]);
            return false;
        }

        $userName = $bansos->user?->name;
        $namaBansos = $bansos->jenisBansos?->nama_bansos;
        $keterangan = $bansos->keterangan;

        $message = match ($event) {
            'approved' => "Halo {$userName}, permohonan {$namaBansos} Anda telah disetujui. Anda terdaftar sebagai penerima bansos dan akan dihubungi oleh petugas desa untuk proses selanjutnya. Selamat!",
            'rejected' => "Halo {$userName}, permohonan {$namaBansos} Anda telah ditolak." . ($keterangan ? " Keterangan: {$keterangan}." : ''),
            default => null,
        };

        if (!$message) {
            return false;
        }

        return $this->send($phone, $token, $message, "bansos {$bansos->id} ({$event})");
    }

    public function sendCustomMessage(?string $phone, string $message, array $context = []): bool
    {
        $phone = $this->normalizePhone($phone);
        $token = config('services.fonnte.token');

        if (!$phone || !$token) {
            Log::warning('Notifikasi WhatsApp Fonnte tidak dikirim karena nomor telepon atau token belum tersedia.', [
                'context' => $context,
                'has_phone' => (bool) $phone,
                'has_token' => (bool) $token,
            ]);
            return false;
        }

        return $this->send($phone, $token, $message, json_encode($context));
    }

    private function send(string $phone, string $token, string $message, string $context): bool
    {
        try {
            $response = Http::asForm()
                ->withHeaders(['Authorization' => $token])
                ->withOptions(['verify' => config('services.fonnte.verify_ssl')])
                ->timeout(15)
                ->post('https://api.fonnte.com/send', [
                    'target' => $phone,
                    'message' => $message,
                ]);

            $result = $response->json();
            $success = $response->successful() && ($result['status'] ?? false) === true;

            if (!$success) {
                Log::error('Fonnte menolak pengiriman notifikasi WhatsApp.', [
                    'context' => $context,
                    'status' => $response->status(),
                    'response' => $result,
                ]);
            }

            return $success;
        } catch (ConnectionException $exception) {
            Log::error('Tidak dapat terhubung ke API Fonnte.', [
                'context' => $context,
                'error' => $exception->getMessage(),
            ]);
            return false;
        }
    }

    private function normalizePhone(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }

        $phone = preg_replace('/[^0-9+]/', '', $phone);

        if (str_starts_with($phone, '+62')) {
            return '62'.substr($phone, 3);
        }

        if (str_starts_with($phone, '62')) {
            return $phone;
        }

        if (str_starts_with($phone, '0')) {
            return '62'.substr($phone, 1);
        }

        return $phone;
    }
}