<?php

namespace Database\Seeders;

use App\Models\Perihal;
use Illuminate\Database\Seeder;

class PerihalSeeder extends Seeder
{
    public function run(): void
    {
        // Perihal umum - berlaku untuk semua jenis surat (jenis_surat_id = null)
        $perihalUmum = [
            'Permohonan Izin',
            'Permohonan Penawaran',
            'Konfirmasi Pembayaran',
            'Pengajuan Anggaran',
            'Laporan Bulanan',
            'Laporan Tahunan',
            'Undangan Rapat',
            'Notulensi Rapat',
            'Pemberitahuan',
            'Koordinasi Antar Departemen',
            'Permintaan Data / Informasi',
            'Tindak Lanjut',
            'Serah Terima Dokumen',
            'Serah Terima Barang',
            'Pengajuan Pengadaan',
            'Evaluasi Kinerja',
            'Perpanjangan Kontrak',
            'Pemutusan Kontrak',
            'Sertifikasi / Perizinan',
            'Lain-lain',
        ];

        foreach ($perihalUmum as $nama) {
            Perihal::firstOrCreate(['nama' => $nama, 'jenis_surat_id' => null]);
        }
    }
}
