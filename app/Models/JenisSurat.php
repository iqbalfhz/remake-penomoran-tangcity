<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class JenisSurat extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jenis_surat';

    protected $fillable = ['kode', 'nama', 'warna'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->useLogName('jenis_surat')
            ->setDescriptionForEvent(fn (string $eventName) => "Jenis Surat {$this->nama} {$eventName}");
    }

    public function perihal(): HasMany
    {
        return $this->hasMany(Perihal::class);
    }

    public function nomorUrut(): HasMany
    {
        return $this->hasMany(NomorUrut::class);
    }

    public function dokumen(): HasMany
    {
        return $this->hasMany(Dokumen::class);
    }
}
