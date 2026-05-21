<?php

namespace App\Console\Commands;

use App\Models\NomorUrut;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetNomorUrut extends Command
{
    protected $signature = 'nomor:reset {--force : Jalankan tanpa konfirmasi}';

    protected $description = 'Reset nomor urut dokumen ke 0 (dijalankan setiap 1 Januari)';

    public function handle(): int
    {
        if (! $this->option('force')) {
            if (! $this->confirm('Reset semua nomor urut ke 0? Aksi ini tidak bisa dibatalkan.')) {
                $this->info('Reset dibatalkan.');
                return self::SUCCESS;
            }
        }

        $tahunSekarang = now()->year;

        $jumlah = NomorUrut::where('tahun', '<', $tahunSekarang)->count();

        // Hapus record tahun lalu (bukan reset ke 0 agar history bersih)
        // Counter tahun baru akan dibuat otomatis saat dokumen pertama dibuat
        NomorUrut::where('tahun', '<', $tahunSekarang)->delete();

        $this->info("Reset berhasil! {$jumlah} record nomor urut tahun lama dihapus.");
        $this->info('Nomor urut tahun ' . $tahunSekarang . ' siap dimulai dari 001.');

        activity()
            ->withProperties(['tahun' => $tahunSekarang, 'deleted_records' => $jumlah])
            ->log('Reset nomor urut tahunan dijalankan');

        return self::SUCCESS;
    }
}
