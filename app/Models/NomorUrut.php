<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NomorUrut extends Model
{
    use HasFactory;

    protected $table = 'nomor_urut';

    protected $fillable = ['jenis_surat_id', 'kode_pt', 'tahun', 'no_urut'];

    protected $casts = [
        'tahun'   => 'integer',
        'no_urut' => 'integer',
    ];

    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public static function getNextNomor(int $jenisSuratId, string $kodePt, int $tahun): int
    {
        $record = static::firstOrCreate(
            ['jenis_surat_id' => $jenisSuratId, 'kode_pt' => $kodePt, 'tahun' => $tahun],
            ['no_urut' => 0]
        );
        $record->increment('no_urut');

        return $record->fresh()->no_urut;
    }
}
