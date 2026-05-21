<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Perihal extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'perihal';

    protected $fillable = ['nama', 'jenis_surat_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('perihal')
            ->setDescriptionForEvent(fn (string $eventName) => "Perihal {$this->nama} {$eventName}");
    }

    public function jenisSurat(): BelongsTo
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function dokumen(): BelongsToMany
    {
        return $this->belongsToMany(Dokumen::class, 'dokumen_perihal');
    }
}
