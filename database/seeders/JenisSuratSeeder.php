<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'SK',  'nama' => 'Surat Keluar',         'warna' => 'primary'],
            ['kode' => 'IM',  'nama' => 'Internal Memo',        'warna' => 'info'],
            ['kode' => 'SPK', 'nama' => 'Surat Perintah Kerja', 'warna' => 'warning'],
            ['kode' => 'PR',  'nama' => 'Purchase Request',     'warna' => 'success'],
            ['kode' => 'PO',  'nama' => 'Purchase Order',       'warna' => 'success'],
            ['kode' => 'MOU', 'nama' => 'MOU / Perjanjian',     'warna' => 'danger'],
            ['kode' => 'SK2', 'nama' => 'Surat Keputusan',      'warna' => 'danger'],
            ['kode' => 'BA',  'nama' => 'Berita Acara',         'warna' => 'gray'],
        ];

        foreach ($data as $item) {
            JenisSurat::firstOrCreate(['kode' => $item['kode']], $item);
        }
    }
}
