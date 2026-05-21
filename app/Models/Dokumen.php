<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Dokumen extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'dokumen';

    protected $fillable = [
        'no_dokumen', 'jenis_surat_id', 'kode_pt',
        'departemen_id', 'user_id', 'tanggal', 'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public static array $kodePtOptions = ['EFM', 'SSK', 'PAKAR', 'FIKA', 'KOPERASI'];

    public static array $bulanRomawi = [
        1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV',
        5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII',
        9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII',
    ];

    public static function generateNomor(
        int $jenisSuratId,
        string $kodePt,
        string $kodeDept,
        Carbon $tanggal
    ): string {
        $jenisSurat = JenisSurat::findOrFail($jenisSuratId);
        $tahun      = $tanggal->year;
        $bulan      = static::$bulanRomawi[$tanggal->month];
        $noUrut     = NomorUrut::getNextNomor($jenisSuratId, $kodePt, $tahun);

        $kodePtSingkat = match ($kodePt) {
            'EFM'      => 'E',
            'SSK'      => 'S',
            'PAKAR'    => 'P',
            'FIKA'     => 'F',
            'KOPERASI' => 'K',
        };

        return sprintf(
            '%03d/%s-%s/%s/%s/%d',
            $noUrut,
            $jenisSurat->kode,
            $kodePtSingkat,
            $kodeDept,
            $bulan,
            $tahun
        );
    }

    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function departemen(): BelongsTo
    {
        return $this->belongsTo(Departemen::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function perihal(): BelongsToMany
    {
        return $this->belongsToMany(Perihal::class, 'dokumen_perihal');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('dokumen')
            ->setDescriptionForEvent(fn (string $eventName) => "Dokumen {$this->no_dokumen} {$eventName}");
    }
}
