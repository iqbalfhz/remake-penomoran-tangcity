<?php

namespace Database\Seeders;

use App\Models\Departemen;
use Illuminate\Database\Seeder;

class DepartemenSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['kode' => 'ACCT',  'nama' => 'Accounting'],
            ['kode' => 'CALE',  'nama' => 'Casual Lease'],
            ['kode' => 'DEV',   'nama' => 'Developer'],
            ['kode' => 'FNB',   'nama' => 'Food & Beverage'],
            ['kode' => 'HR',    'nama' => 'Human Resources'],
            ['kode' => 'IT',    'nama' => 'Information Technology'],
            ['kode' => 'LEG',   'nama' => 'Legal'],
            ['kode' => 'MKT',   'nama' => 'Marketing'],
            ['kode' => 'OPS',   'nama' => 'Operations'],
            ['kode' => 'PROP',  'nama' => 'Property'],
            ['kode' => 'PURC',  'nama' => 'Purchasing'],
            ['kode' => 'SEC',   'nama' => 'Security'],
            ['kode' => 'TECH',  'nama' => 'Technical'],
        ];

        foreach ($data as $item) {
            Departemen::firstOrCreate(['kode' => $item['kode']], $item);
        }
    }
}
