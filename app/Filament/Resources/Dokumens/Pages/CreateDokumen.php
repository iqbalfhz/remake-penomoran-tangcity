<?php

namespace App\Filament\Resources\Dokumens\Pages;

use App\Filament\Resources\Dokumens\DokumenResource;
use App\Models\Departemen;
use App\Models\Dokumen;
use Carbon\Carbon;
use Filament\Resources\Pages\CreateRecord;

class CreateDokumen extends CreateRecord
{
    protected static string $resource = DokumenResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        $departemen = Departemen::findOrFail($data['departemen_id']);

        $data['no_dokumen'] = Dokumen::generateNomor(
            (int) $data['jenis_surat_id'],
            $data['kode_pt'],
            $departemen->kode,
            Carbon::parse($data['tanggal'])
        );

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
