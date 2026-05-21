<?php

namespace App\Filament\Widgets;

use App\Models\Dokumen;
use App\Models\JenisSurat;
use App\Models\NomorUrut;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $tahun = now()->year;
        $stats = [];

        // Total dokumen hari ini
        $stats[] = Stat::make('Dokumen Hari Ini', Dokumen::whereDate('tanggal', today())->count())
            ->description('Total surat masuk hari ini')
            ->icon('heroicon-o-document-plus')
            ->color('success');

        // Total dokumen bulan ini
        $stats[] = Stat::make('Dokumen Bulan Ini', Dokumen::whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', $tahun)->count())
            ->description('Selama ' . now()->format('F Y'))
            ->icon('heroicon-o-calendar-days')
            ->color('info');

        // Counter per Jenis Surat tahun ini
        $jenisSurats = JenisSurat::all();
        foreach ($jenisSurats as $jenis) {
            $total = NomorUrut::where('jenis_surat_id', $jenis->id)
                ->where('tahun', $tahun)
                ->sum('no_urut');

            $stats[] = Stat::make($jenis->nama, $total)
                ->description('Nomor urut ' . $tahun)
                ->icon('heroicon-o-document-text')
                ->color($jenis->warna);
        }

        return $stats;
    }
}
